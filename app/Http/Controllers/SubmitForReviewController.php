<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\NotificationCourse;
use App\Models\NotificationEntity;
use App\Models\ReviewCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubmitForReviewController extends Controller
{
    public function index(Request $request)
    {
        $course_id = $request->input('course_id');

        $course = Course::where('author_id', Auth::user()->id)
            ->where('id', $course_id)
            ->first(['id']);

        if ($course) {
            Course::where('id', $course_id)
                ->update(
                    ['submit_for_review' => 1]
                );

            $entity_id = NotificationEntity::where('option', 'submit_for_review')->first(['id']);

            NotificationCourse::updateOrCreate([
                'entity_id' => $entity_id->id,
                'course_id' => $course_id,
            ]);

            ReviewCourse::updateOrCreate(['course_id' => $course_id]);

            return redirect()->route('instructor-courses');
        }
    }
}
