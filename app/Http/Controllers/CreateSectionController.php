<?php

namespace App\Http\Controllers;

use App\Models\Sections;
use Illuminate\Http\Request;

class CreateSectionController extends Controller
{
    public function index(Request $request)
    {
        $request->validate(
            [
                'title' => ['required', 'max:80'],
                'course_id' => ['required', 'numeric']
            ]
        );

        $order = Sections::where(
            'course_id',
            $request->input('course_id')
        )
            ->orderBy('order', 'desc')
            ->first(['order']);
        $order = $order ? $order->order + 1 : 1;

        $id_lecture = Sections::insertGetId(
            [
                'course_id' => $request->input('course_id'),
                'title' => $request->input('title'),
                'order' => $order
            ]
        );

        return Sections::firstWhere('id', $id_lecture);
    }
}
