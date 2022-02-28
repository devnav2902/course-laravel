<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lectures;
use App\Models\Progress;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LearningController extends Controller
{
    public function index($url)
    {

        $course = Course::with(
            [
                'lecture' => function ($q) {
                    $q->select('lectures.title', 'lectures.id', 'src', 'original_filename', 'lectures.order');
                },
                'lecture.progress' => function ($q) {
                    $q->select('lecture_id', 'progress');
                },
                'section.countProgress'
            ]
        )
            ->without('category', 'course_bill')
            ->where('slug', $url)
            ->get();

        if (count($course)) $course = $course[0];

        $author = $course->author;

        $data_progress = $course->lecture
            ->map(function ($lecture) {
                return collect($lecture->progress)->all();
            })
            ->filter()
            ->values(); // reset key

        return view('pages.learning', compact(
            ['course', 'data_progress', 'author']
        ));
    }
}
