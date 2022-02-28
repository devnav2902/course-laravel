<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseBill;
use App\Models\CourseCoupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FreeEnrollController extends Controller
{
    function freeEnroll(Request $request)
    {
        $request->validate([
            'course_id' => 'required',
            'coupon' => 'uuid',
            'code' => 'regex:/[A-Z0-9\-\.\_]/', 'min:6', 'max:20'
        ]);

        $helper = new HelperController;
        $course = null;
        $course_id = $request->input('course_id');
        $coupon = $helper->getCoupon($request->input('code'), $course_id);
        $code = $coupon->code ?? '';

        $course = Course::where('id', $course_id)
            ->whereHas('price', function ($query) {
                $query->where('price', 0.0);
            })
            ->orWhereHas('coupon', function ($query) use ($code) {
                $query->where('code', $code);
            })
            ->first(['id', 'price_id', 'slug', 'title', 'thumbnail']);

        if (!$course) return back();

        try {
            CourseBill::create(
                [
                    'user_id' => Auth::user()->id,
                    'course_id' => $course->id,
                    'title' => $course->title,
                    'thumbnail' => $course->thumbnail,
                    'purchase' => 0.0,
                    'price' => $course->price->price,
                    'promo_code' => $code
                ]
            );
        } catch (\Throwable $th) {
            return redirect()->route('course', ['url' => $course->slug]);
        }

        if (!empty($coupon)) {
            $currently_enrolled = $coupon->currently_enrolled + 1;
            CourseCoupon::where('code', $code)
                ->where('course_id', $course_id)
                ->update(['currently_enrolled' => $currently_enrolled]);
        }

        return redirect()->route('learning', ['url' => $course->slug]);
    }
}
