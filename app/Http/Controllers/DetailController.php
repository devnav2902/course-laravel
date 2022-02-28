<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use stdClass;
use Artesaos\SEOTools\Facades\SEOMeta;

class DetailController extends Controller
{
    function index(Request $request, $url)
    {
        $course = Course::where('slug', $url)
            ->where('isPublished', 1)
            ->with([
                'lecture',
                'lecture.progress' => function ($q) {
                    $q->where('progress', 1);
                }
            ])
            ->withAvg('rating', 'rating')
            ->withCount(['course_bill', 'rating', 'section'])
            ->get();

        if (!count($course)) abort(404);

        $course->transform(function ($course) {
            $course->setRelation('rating', $course->rating()->paginate(10));

            $helper = new HelperController;
            $count = $helper->countProgress($course->lecture);
            $course->count_progress = $count;
            return $course;
        });

        $course = $course[0];

        // SEO
        SEOMeta::setTitle($course->title);

        $isPurchased = false;
        $isFree = $course->price->price === 0.0 ? true : false;

        if (Auth::check()) {
            $result = Auth::user()
                ->enrollment
                ->firstWhere('course_id', $course->id);

            $isPurchased = $result ? true : false;

            $course->hasCommented =
                Rating::where('user_id', Auth::user()->id)
                ->select('course_id')
                ->firstWhere('course_id', $course->id);
        }

        // RATING
        $graph = $this->ratingGraph($course);

        if ($request->isMethod('GET'))
            return view('pages.course-lesson', compact(['graph', 'course', 'isPurchased', 'isFree']));

        $code = $request->input('coupon-input');

        $helper = new HelperController;

        $coupon = $helper->getCoupon($code, $course->id);

        $couponJSON = collect($coupon)
            ->only(['course_id', 'coupon_id', 'code', 'discount_price'])->toJson();

        $saleOff = 100;
        $isFreeCoupon = false;

        if ($coupon) {
            $original_price = $course->price->price;
            $discount_price = $coupon->discount_price;

            $total = $original_price - $discount_price;
            if ($total == $original_price) $isFreeCoupon = true;
            else $saleOff = round(($total / $original_price) * 100);
        }

        return view(
            'pages.course-lesson',
            compact(
                ['isPurchased', 'course', 'graph', 'coupon', 'couponJSON', 'saleOff', 'isFreeCoupon', 'isFree']
            )
        );
    }

    public function createObj($rating, $percent)
    {
        $obj = new stdClass;
        $obj->rating = $rating;
        $obj->percent = $percent;
        return $obj;
    }

    public function ratingGraph($course)
    {
        $graph = [];

        for ($i = 1; $i <= 4; $i++) {
            $count_rating = $course
                ->rating
                ->where('rating', $i)
                ->count();

            $percent = 0;
            if ($course->rating_count) {
                $percent = ROUND(($count_rating * 100 / $course->rating_count), 1);
            }

            $graph[] = $this->createObj($i, $percent);
        }

        $sum = collect($graph)->sum('percent');
        $rest = 0;

        if (count($course->rating)) $rest = 100 - $sum;

        $graph[] = $this->createObj(5, $rest);

        return $graph;
    }
}
