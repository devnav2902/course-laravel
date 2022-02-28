<?php

namespace App\Http\Controllers;

use App\Models\CategoriesCourse;
use App\Models\Course;
use Illuminate\Http\Request;

class AutoSaveController extends Controller
{
    public function index(Request $request, $course_id)
    {
        Course::where('id', $course_id)->update($request->except('category'));


        CategoriesCourse::where('course_id', $course_id)->delete();

        if ($request->has('category')) {
            $arr = [];

            foreach ($request->input('category') as  $value) {
                $arr[] = ['category_id' => $value, 'course_id' => $course_id];
            }

            CategoriesCourse::insert($arr);
        }


        return 'success';
    }
}
