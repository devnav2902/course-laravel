<?php

namespace App\Http\Middleware;

use App\Models\Course;
use App\Models\ReviewCourse as ModelsReviewCourse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewCourse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        $review_course = ModelsReviewCourse::where(
            'course_id',
            $request->route('id')
        )
            ->first(['id']);

        if ($review_course)
            return $next($request);

        return abort(404);
    }
}
