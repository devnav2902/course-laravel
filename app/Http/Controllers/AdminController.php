<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ReviewCourse;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // public function category()
    // {
    //     $categories = Category::get();

    //     return view('pages.add-category', compact('categories'));
    // }

    function review()
    {
        $courses = ReviewCourse::with(['course'])->get();


        return view('pages.admin-review', compact(['courses']));
    }
}
