<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseCoupon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class HelperController extends Controller
{
    static function render_star($ratingAverage)
    {
        $render = '';
        $render .= $ratingAverage >= 1 ?
            "<i class='fas fa-star'></i>" : ($ratingAverage >= 0.5 ?
                "<i class='fas fa-star-half'></i>" :
                "<i class='far fa-star'></i>");

        $render .=  $ratingAverage >= 2 ?
            "<i class='fas fa-star'></i>" : ($ratingAverage >= 1.5 ?
                "<i class='fas fa-star-half'></i>" :
                "<i class='far fa-star'></i>");

        $render .=  $ratingAverage >= 3 ?
            "<i class='fas fa-star'></i>" : ($ratingAverage >= 2.5 ?
                "<i class='fas fa-star-half'></i>" :
                "<i class='far fa-star'></i>");

        $render .=  $ratingAverage >= 4 ?
            "<i class='fas fa-star'></i>" : ($ratingAverage >= 3.5 ?
                "<i class='fas fa-star-half'></i>" :
                "<i class='far fa-star'></i>");

        $render .=  $ratingAverage >= 5 ?
            "<i class='fas fa-star'></i>" : ($ratingAverage >= 4.5 ?
                "<i class='fas fa-star-half'></i>" :
                "<i class='far fa-star'></i>");

        return $render;
    }

    function getCourseOfInstructor($course_id)
    {
        return Course::where('author_id', Auth::user()->id)
            ->with(
                [
                    'section',
                    'lecture',
                ]
            )
            ->firstWhere('id', $course_id);
    }

    function countProgress($lectures)
    {
        $progress = array();
        foreach ($lectures as $lecture) {
            if (!empty($lecture->progress))
                $progress[] = $lecture->progress;
        }

        return collect($progress)->count();
    }

    function getCoupon($code, $course_id)
    {
        $query = CourseCoupon::with('coupon')
            ->where('code', $code)
            ->where('course_id', $course_id)
            ->where("status", 1);

        $queryCourseCoupon = clone $query;
        $courseCoupon = $queryCourseCoupon
            ->first(['expires', 'enrollment_limit', 'currently_enrolled', 'course_id', 'coupon_id', 'code', 'discount_price', 'status']);

        if (!$courseCoupon) return null;

        $coupon = $courseCoupon->coupon;
        $enrollment_limit = $coupon->enrollment_limit;

        $isExpired = null;
        // UNLIMITED
        if ($enrollment_limit) {
            $query = clone $query;
            $isExpired = $query
                ->whereDate('expires', '<', Carbon::now())
                ->orWhereDate('expires', Carbon::now())
                ->whereTime('expires', '<', Carbon::now())
                ->orWhere('currently_enrolled', '>=', $enrollment_limit);
        } else {
            // CHECK DATETIME
            $query = clone $query;
            $isExpired = $query
                ->whereDate('expires', '<', Carbon::now())
                ->orWhereDate('expires', Carbon::now())
                ->whereTime('expires', '<', Carbon::now());
        }

        $isExpired = $isExpired->first(['course_id']);

        if ($isExpired) {
            $this->updateStateCoupon($code, $course_id);

            return null;
        }

        return $courseCoupon;
    }

    private function updateStateCoupon($code, $course_id)
    {
        CourseCoupon::where('course_id', $course_id)
            ->where('code', $code)
            ->update(['status' => 0]);
    }
}
