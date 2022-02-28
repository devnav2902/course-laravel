<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Artesaos\SEOTools\Facades\SEOMeta;


class CourseLandingPageController extends Controller
{
    public function entryCourse($course_id)
    {
        $helper = new HelperController;
        $course = $helper->getCourseOfInstructor($course_id);
        if (!$course) abort(404);
        SEOMeta::setTitle('Thông tin cơ bản');


        $categories = $this->category_course($course_id);

        return view('pages.course-landing-page', compact(['course', 'categories']));
    }

    private function category_course($course_id)
    {
        $categories = Category::get();

        $helper = new HelperController;
        $course = $helper->getCourseOfInstructor($course_id);

        foreach ($categories as $category) {
            $selected = $course->category()
                ->firstWhere('category.id', $category->id);

            if ($selected) $category->selected = true;
        }

        return $categories;
    }
}
