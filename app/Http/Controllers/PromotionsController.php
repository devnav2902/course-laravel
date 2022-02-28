<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Course;
use App\Models\CourseCoupon;
use App\Models\Price;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Support\Facades\DB;

class PromotionsController extends Controller
{
    function promotions(Request $request, $course_id)
    {
        DB::enableQueryLog();
        SEOMeta::setTitle('Chương trình khuyến mãi');

        $showFormCreate = false;
        if ($request->isMethod('post'))
            $showFormCreate = true;

        $helper = new HelperController;
        $course = $helper->getCourseOfInstructor($course_id);

        $isFree =
            $course->price->price === 0.0 ? true : false;

        $isValid = $this->checkToCreateCoupon($course_id) && !$isFree;
        $current_month = Carbon::now()->englishMonth;

        $query = CourseCoupon::without('coupon')
            ->where('course_id', $course_id)
            ->where('status', 1);

        $queryCoupons = clone $query;
        $arrCoupons = $queryCoupons->get();

        $active_coupons  = [];
        foreach ($arrCoupons as $item) {
            $active_coupons[] =
                $helper->getCoupon($item->code, $course_id);
        }

        $active_coupons = collect($active_coupons)
            ->map(function ($coupon) {
                $expires = $coupon->expires;
                $time_remaining = Carbon::now()->diffInDays(
                    $expires,
                    false
                );

                if ($time_remaining <= $coupon->coupon->limited_time)
                    $coupon->time_remaining = $time_remaining;

                $coupon->expires = Carbon::parse($expires)
                    ->isoFormat('DD/MM/YYYY HH:mm A zz');

                return $coupon;
            });

        $types_of_coupons = Coupon::all();

        return view(
            'pages.promotions',
            compact(
                [
                    'course',
                    'types_of_coupons',
                    'isValid',
                    'current_month',
                    'showFormCreate',
                    'active_coupons'
                ]
            )
        );
    }

    function data(Request $request)
    {
        if ($request->filled('id_type'))
            return Coupon::find($request->input('id_type'));

        return Coupon::all();
    }

    function queryCouponByCourseId($course_id)
    {
        $current_month = Carbon::now()->month;
        $current_year = Carbon::now()->year;

        $couponInMonth =
            CourseCoupon::where('course_id', $course_id)
            ->whereMonth('created_at', $current_month)
            ->whereYear('created_at', $current_year);

        return $couponInMonth;
    }

    function createCoupon(Request $request)
    {

        $input = array_filter($request
            ->only(
                ['code', 'coupon_type', 'discount_price', 'enrollment_limit']
            ));

        $request->validate(['course_id' => 'required']);

        $course = Course::find(
            $request->input('course_id'),
            ['id', 'price_id']
        );

        $price = Price::find($course->price_id);
        if (empty($price) || $price->price == 0.0) return false;
        else $price = $price->price;

        Validator::make($input, [
            'code' => [
                'required', 'regex:/[A-Z0-9\-\.\_]/', 'min:6', 'max:20'
            ],
            'coupon_type' => 'required',
            'discount_price' => 'integer|min:2|lt:' . $price,
        ])->validate();

        $coupon_type = Coupon::where('id', $input['coupon_type'])->first();
        $enrollment_limit = $coupon_type->enrollment_limit;

        // DEFAULT VALUE IF EMPTY FIELD
        if (empty($input['enrollment_limit']))
            $input['enrollment_limit'] = $enrollment_limit; // no limit
        else {
            if ($enrollment_limit) {
                $request->validate(
                    [
                        'enrollment_limit' => 'integer|min:1|lte:' . $enrollment_limit
                    ]
                );
            } else $request->validate(['enrollment_limit' => 'integer|min:1']);
        }

        $isValid = $this->checkToCreateCoupon($course->id);
        if ($isValid) {
            $discount_price =
                isset($input['discount_price'])
                ? $input['discount_price'] + 0.99
                : 0.0;

            CourseCoupon::create([
                'code' => $input['code'],
                'coupon_id' => $input['coupon_type'],
                'status' => 1,
                'course_id' => $course->id,
                'discount_price' => $discount_price,
                'enrollment_limit' => $input['enrollment_limit'],
                'expires' => Carbon::now()->addDays($coupon_type->limited_time)
            ]);

            return true;
        }
        return false;
    }

    function checkToCreateCoupon($course_id)
    {
        $couponInMonth =
            $this->queryCouponByCourseId($course_id)
            ->where('status', 1)
            ->get();

        $numberCouponInMonth = $couponInMonth->count();

        if ($numberCouponInMonth < 3) return true;
        else return false;
    }
}
