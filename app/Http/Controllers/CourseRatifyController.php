<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\NotificationCourse;
use App\Models\NotificationEntity;
use App\Models\ReviewCourse;
use Illuminate\Http\Request;

class CourseRatifyController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'option' => 'required',
            'course_id' => 'required'
        ]);
        $option = $request->input('option');
        $entity = NotificationEntity::where('option', $option)
            ->first('id');
        $course = Course::find($request->input('course_id'));

        if ($entity && $course) {
            NotificationCourse::updateOrCreate([
                'course_id' => $course->id
            ], ['entity_id' => $entity->id]);

            if ($option == 'approved') {
                Course::where('id', $course->id)
                    ->update(
                        [
                            'isPublished' => 1, 'submit_for_review' => 0
                        ]
                    );
            } elseif ($option == 'unapproved') {
                Course::where('id', $course->id)
                    ->update(['submit_for_review' => 0]);
            }

            ReviewCourse::where('course_id', $course->id)
                ->delete();
        }

        return redirect()->route('submission-courses-list');
    }
}
