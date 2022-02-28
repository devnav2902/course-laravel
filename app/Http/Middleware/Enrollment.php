<?php

namespace App\Http\Middleware;

use App\Models\Course;
use App\Models\CourseBill;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Enrollment
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
        $url = $request->route('url');

        $enrolled = CourseBill::whereHas('course', function ($query) use ($url) {
            $query->where('slug', $url);
        })
            ->where('user_id', Auth::user()->id)
            ->first(['course_id']);

        $author = Course::where('author_id', Auth::user()->id)
            ->where('slug', $url)
            ->first(['author_id']);

        $isAdmin = Auth::user()->role->name === 'admin' ? true : false;

        if ($enrolled || $author || $isAdmin)
            return $next($request);

        return abort(404);
    }
}
