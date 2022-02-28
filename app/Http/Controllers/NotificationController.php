<?php

namespace App\Http\Controllers;

use App\Models\NotificationCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notification_course = NotificationCourse::whereHas('course', function ($query) {
            $query->where('author_id', Auth::user()->id);
        })->get();

        return view('pages.notifications', compact(['notification_course']));
    }
}
