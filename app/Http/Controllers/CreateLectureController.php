<?php

namespace App\Http\Controllers;

use App\Models\Lectures;
use Illuminate\Http\Request;

class CreateLectureController extends Controller
{
    public function index(Request $request)
    {
        $request->validate(
            [
                'title' => ['required', 'max:80'],
                'section_id' => ['required', 'numeric']
            ]
        );

        $order = Lectures::where(
            'section_id',
            $request->input('section_id')
        )
            ->orderBy('order', 'desc')
            ->first(['order']);
        $order = $order ? $order->order + 1 : 1;

        $id_lecture = Lectures::insertGetId(
            [
                'section_id' => $request->input('section_id'),
                'title' => $request->input('title'),
                'order' => $order
            ]
        );

        return Lectures::firstWhere('id', $id_lecture);
    }
}
