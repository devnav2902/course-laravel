<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\Price;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Artesaos\SEOTools\Facades\SEOMeta;


class InstructorController extends Controller
{

    public function index($slug)
    {

        $author = User::with('bio')
            ->where('slug', $slug)
            ->first(['id', 'avatar', 'fullname']);

        if (!$author) return abort(404);
        SEOMeta::setTitle($author->fullname);

        $course = Course::where('author_id', $author->id)
            ->where('isPublished', 1)
            ->withCount('course_bill')
            ->withCount('rating');

        $queryTotalStudents = clone $course;
        $totalStudents = $queryTotalStudents
            ->get(['id'])
            ->sum('course_bill_count');

        $queryTotalCourses = clone $course;
        $totalCourses = $queryTotalCourses->get(['id'])->count();

        $queryTotalReviews = clone $course;
        $totalReviews = $queryTotalReviews->whereHas('rating', function ($q) {
            $q->where('content', '<>', '');
        })
            ->get(['id'])
            ->sum('rating_count');

        $courses = $course->orderBy('created_at', 'desc')
            ->withAvg('rating', 'rating')
            ->paginate(
                6,
                ['title', 'id', 'author_id', 'created_at', 'price', 'slug']
            );

        return view('pages.instructor-bio', compact(['author', 'courses', 'totalStudents', 'totalReviews', 'totalCourses']));
    }

    public function instructor()
    {
        SEOMeta::setTitle('Khóa học của bạn');

        $courses = Course::setEagerLoads([])
            ->orderBy("created_at", 'desc')
            ->with(['category', 'section'])
            ->where('author_id', Auth::user()->id)
            ->withAvg('rating', 'rating')
            ->withCount('course_bill')
            ->paginate(6);

        return view('pages.instructor-course', compact(['courses']));
    }

    // public function draft($id)
    // {
    //     $course = $this->getCourse($id);
    //     if (!$course) abort(404);

    //     return view('pages.draft-course', compact(['course']));
    // }


}
