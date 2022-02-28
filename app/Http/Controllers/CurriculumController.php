<?php

namespace App\Http\Controllers;

use Artesaos\SEOTools\Facades\SEOMeta;

class CurriculumController extends Controller
{
    public function curriculum($course_id)
    {
        SEOMeta::setTitle('Chương trình giảng dạy');

        $helper = new HelperController;
        $course = $helper->getCourseOfInstructor($course_id);
        if (!$course) abort(404);

        return view('pages.curriculum', compact(['course']));
    }
}
