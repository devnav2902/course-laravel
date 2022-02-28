<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Artesaos\SEOTools\Facades\SEOMeta;

class CartController extends Controller
{
    public function index()
    {
        SEOMeta::setTitle('Shopping cart');

        return view('pages.shopping-cart');
    }

    function applyingCoupon(Request $request)
    {
        $request->validate([
            'coupon' => [
                'required',
                'regex:/[A-Z0-9\-\.\_]/',
                'min:6',
                'max:20'
            ],
            'courses' => ['required', 'array']
        ]);

        $courses = $request->input('courses');
        $code = $request->input('coupon');

        return $this->applyingCouponsToCourses($courses, $code);
    }

    function getCourses(Request $request)
    {
        $request->validate([
            'courses' => 'array|required'
        ]);

        $courses =  $request->input('courses');
        $arrCourses = collect($this->courses($courses));
        $helper = new HelperController;

        $arrCourses->transform(function ($course) use ($courses, $helper) {
            $courseItem = collect($courses)->firstWhere('id', $course->id);

            if (!$courseItem) return null;

            if (!empty($courseItem['coupon']['code'])) {
                $code = $courseItem['coupon']['code'];

                $coupon = $helper->getCoupon($code, $course->id);
                if ($coupon) {
                    $coupon = collect($coupon)
                        ->except(
                            ['coupon', 'expires', 'enrollment_limit', 'currently_enrolled']
                        );

                    $course->coupon = $coupon;
                }
            }

            return $course;
        })
            ->filter()
            ->values();

        return $arrCourses;
        // $coupons = collect($courses)->pluck('coupon.code');

    }

    function applyingCouponsToCourses($courses, $code)
    {
        $arrCourses = collect($this->courses($courses));
        $helper = new HelperController;

        $arrCourses->transform(function ($course) use ($code, $helper) {
            $coupon = $helper->getCoupon($code, $course->id);
            if ($coupon) {
                $coupon = collect($coupon)
                    ->except(
                        ['expires', 'enrollment_limit', 'currently_enrolled', 'coupon']
                    );
            }
            $course->coupon = $coupon;
            return $course;
        });

        return $arrCourses;
    }

    private function courses($arrCourses)
    {
        $courses = collect($arrCourses)->pluck('id');

        $query = Course::withOnly([
            'author' => function ($q) {
                $q
                    ->without(['bio', 'role', 'enrollment'])
                    ->select('fullname', 'id', 'slug');
            },
            'rating' => function ($q) {
                $q
                    ->without(['user'])
                    ->select('rating', 'course_id');
            },
            'price',
        ])
            ->select('slug', 'id', 'author_id', 'price_id', 'thumbnail', 'title')
            ->withAvg('rating', 'rating') // after select
            ->withCount(['course_bill', 'rating'])
            ->whereIn('id', $courses);


        if (!Auth::check()) {
            $queryGuest = clone $query;
            return $queryGuest->get();
        }

        $queryAuth = clone $query;
        return $queryAuth
            // ->doesntHave('course_bill') !!!!!!!!!!!
            ->where('author_id', '<>', Auth::user()->id)
            ->get();
    }
}
