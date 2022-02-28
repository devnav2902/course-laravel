<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class ImageUploadController extends Controller
{
    public function index(Request $request)
    {
        $image = $request->file('thumbnail');
        $name = $image->getClientOriginalName();
        $path =  $image->storeAs('thumbnail', time() . $name);
        Course::where('id', $request->input('course-id'))
            ->update(['thumbnail' => $path]);

        return  $path;
    }
}
