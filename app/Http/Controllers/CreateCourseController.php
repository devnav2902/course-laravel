<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Price;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Artesaos\SEOTools\Facades\SEOMeta;

class CreateCourseController extends Controller
{
    function index()
    {
        SEOMeta::setTitle('Tạo khóa học');

        return view('pages.create-course');
    }
    function create(Request $request)
    {
        $request->validate([
            'title' => 'required|max:60'
        ]);

        $price_id = Price::firstWhere('price', 0.0)->id;

        $id = Course::insertGetId([
            'title' => $request->input('title'),
            'author_id' => Auth::user()->id,
            'price_id' => $price_id
        ]);

        return redirect()->route('entry-course', ['id' => $id]);
    }
}
