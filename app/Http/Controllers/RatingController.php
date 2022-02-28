<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseBill;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    function index(Request $request)
    {
        $request->validate(
            [
                'course_id' => 'required|numeric',
                'rating' => 'required|min:1|max:5',
                'content' => 'string|nullable'
            ]
        );

        $data = $request->only(['course_id', 'content', 'rating']);

        $registered = CourseBill::where('user_id', Auth::user()->id)
            ->where('course_id', $data['course_id'])
            ->first(['course_id']);

        if ($registered) {
            $rated = Rating::where('course_id', $registered->course_id)
                ->where('user_id', Auth::user()->id)
                ->first(['course_id']);

            if ($rated) return back();

            $data['user_id'] = Auth::user()->id;
            Rating::create($data);
        }
        return back();
    }
}
