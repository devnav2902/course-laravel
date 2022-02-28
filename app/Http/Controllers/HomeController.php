<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        SEOMeta::setTitle('Trang chủ');

        DB::enableQueryLog();

        // $query = CourseCoupon::with('coupon')
        //     ->where('code', 'KEEPLEARNING')
        //     ->where('course_id', 1)
        //     ->where("status", 1);

        // $queryCourseCoupon = clone $query;
        // $courseCoupon = $queryCourseCoupon
        //     ->first('expires', 'enrollment_limit', 'currently_enrolled', 'course_id', 'coupon_id', 'code', 'discount_price');

        // dd(Registration::get());
        // dd(
        //     DB::getQueryLog()
        // );

        $query = Course::without(['section', 'course_bill'])
            ->where('isPublished', 1)
            ->orderBy('created_at', 'desc')
            ->select('title', 'id', 'author_id', 'slug', 'price_id', 'thumbnail', 'created_at')
            ->withCount(['course_bill', 'rating'])
            ->withAvg('rating', 'rating')
            ->take(6);


        $queryLatestCourses = clone $query;
        $latestCourses = $queryLatestCourses->get();

        $queryBestSeller = clone $query;
        $bestseller = $queryBestSeller
            ->has('course_bill', ">=", 1)
            ->get();

        $queryFeaturedCourses = clone $query;
        $featuredCourses =
            $queryFeaturedCourses
            ->having('rating_avg_rating', '>=', 4)
            ->get();


        $popularInstructor =  DB::table("course")
            ->join("users", "users.id", "course.author_id")
            ->join("course_bill", "course.id", "course_bill.course_id")
            ->select(
                [
                    DB::raw("COUNT(course_bill.user_id) as count_students"),
                    "course.author_id",
                ]
            )
            ->groupBy("author_id")
            ->having("count_students", ">=", 2)
            ->orderBy("count_students", "DESC")
            ->limit(6)
            ->get();

        $author_id = $popularInstructor->pluck('author_id');
        $instructors = User::whereIn('id', $author_id)
            ->select('id', 'fullname', 'avatar', 'slug')
            ->withCount('course')
            ->get()
            ->transform(function ($author) use ($popularInstructor) {
                $data = $popularInstructor
                    ->firstWhere("author_id", $author->id);

                $data ? $author->count_students = $data->count_students : null;

                return $author;
            });

        return view('pages.index', compact(['latestCourses', 'featuredCourses', 'bestseller', 'instructors']));
    }
}
