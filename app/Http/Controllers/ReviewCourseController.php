<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class ReviewCourseController extends Controller
{
    public function draft($course_id)
    {
        $isAdmin = Auth::user()->role->name === "admin";

        $course = Course::find($course_id);
        if (!$course) return abort(404);

        $helper = new HelperController;
        if (!$isAdmin) $course = $helper->getCourseOfInstructor($course_id);

        return view('pages.draft-course', compact(['course']));
    }
}
