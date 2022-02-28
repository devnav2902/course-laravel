<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Price;
use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\SEOMeta;

class CoursePriceController extends Controller
{
    public function price($course_id)
    {
        SEOMeta::setTitle('Giá khóa học');

        $helper = new HelperController;
        $course = $helper->getCourseOfInstructor($course_id);
        $allPrice = Price::get();

        return view('pages.price', compact(['allPrice', 'course']));
    }
    public function update_price(Request $request, $id)
    {
        $allPrice = Price::get();
        Course::where('id', $id)
            ->update(
                ['price_id' => $request->input('price')]
            );

        $helper = new HelperController;
        $course = $helper->getCourseOfInstructor($id);

        return view('pages.price', compact(['allPrice', 'course']));
    }

    // private function price_course($course_id)
    // {
    //     $prices = Price::get();
    //     $helper = new HelperController;

    //     $course = $helper->getCourseOfInstructor($course_id);

    //     foreach ($prices as $price) {
    //         $selected = $course->category()
    //             ->firstWhere('price.id', $price->id);

    //         if ($selected)  $price->selected = true;
    //     }


    //     return $prices;
    // }
}
