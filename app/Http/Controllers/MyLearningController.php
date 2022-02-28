<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Artesaos\SEOTools\Facades\SEOMeta;

class MyLearningController extends Controller
{

    public function index()
    {
        SEOMeta::setTitle('My learning');

        $courses = Course::withOnly(
            [
                'lecture' => function ($q) {
                    $q->select('lectures.id');
                },
                'lecture.progress' => function ($q) {
                    $q
                        ->select('lecture_id', 'progress')
                        ->where('progress', 1);
                },
                'author',
                'rating' => function ($q) {
                    $q->where('user_id', Auth::user()->id);
                }
            ]
        )
            ->whereHas(
                'course_bill',
                function ($q) {
                    $q
                        ->orderBy('created_at', 'desc')
                        ->where('user_id', Auth::user()->id);
                }
            )
            ->paginate(5, ['id', 'title', 'slug', 'author_id', 'thumbnail']);

        $courses->transform(function ($course) {
            $totalLecture = $course->lecture->count();

            $helper = new HelperController;
            $count = $helper->countProgress($course->lecture);

            $course->count_progress = number_format($count / $totalLecture, 2);
            return $course;
        });

        return view('pages.my-learning', compact(['courses']));
    }
}
