<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Progress;
use App\Models\Sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UpdateProgressController extends Controller
{
    function updateProgress(Request $request)
    {
        $request->validate(
            [
                'course_id' => 'required',
                'lecture_id' => 'required',
                'checked' => 'required'
            ]
        );

        $lecture_id = $request->input('lecture_id');
        $course = Course::setEagerLoads([])
            ->with(
                [
                    'lecture' => function ($q) {
                        $q->select('lectures.id');
                    },
                    'lecture.progress' => function ($q) {
                        $q->select('lecture_id', 'progress');
                    },
                    'section.countProgress'
                ]
            )
            ->whereHas('lecture', function ($q) use ($lecture_id) {
                $q->where('lectures.id', $lecture_id);
            })
            ->select('id')
            ->firstWhere('id', $request->input('course_id'));

        if (!$course) abort(400);

        Progress::upsert(
            [
                'lecture_id' => $lecture_id,
                'user_id' => Auth::user()->id,
                'progress' => $request->input('checked')
            ],
            ['lecture_id', 'user_id'],
            ['progress']
        );

        // DB::enableQueryLog();
        $section = Sections::withOnly('countProgress')
            ->whereHas('lecture', function ($q) use ($lecture_id) {
                $q->where('id', $lecture_id);
            })
            ->select('id')
            ->first();

        $data_progress = Progress::where('user_id', Auth::user()->id)
            ->where('progress', 1)
            ->whereIn('lecture_id', $course->lecture->pluck('id'))
            ->get(['lecture_id', 'progress']);

        return ['data_progress' => $data_progress, 'section' => $section];
    }
}
