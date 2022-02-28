<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lectures;
use App\Models\Resources;
use App\Models\Sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UpdateCurriculumController extends Controller
{
    function updateTitle(Request $request, $type)
    {

        $request->validate([
            'course' => 'required',
            'id' => 'required',
            'title' => 'required|max:60'
        ]);

        if ($type == 'section') {
            Sections::Where('id', $request->input('id'))
                ->update(['title' => $request->input('title')]);
        } else if ($type == 'lecture') {
            Lectures::where('id', $request->input('id'))
                ->update(['title' => $request->input('title')]);
        }

        return 'success';
    }

    function delete(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'id' => 'required',
            'course_id' => 'required'
        ]);

        $id = $request->input('id');
        if ($request->input('type') == 'section') {
            $querySection = Sections::where('id', $id);
            $section = $querySection->first();
            $order = $section->order;

            $listOfSections = Sections::setEagerLoads([])
                ->where('course_id', $section->course_id)
                ->where('order', '>', $order)
                ->select('id', 'order')
                ->get();

            foreach ($listOfSections as $sec) {
                Sections::where('id', $sec->id)
                    ->update(['order' => $sec->order - 1]);
            }
            $querySection->delete();
        } else {
            $queryLecture = Lectures::select('id', 'order', 'section_id')
                ->where('id', $id);
            $lecture = $queryLecture->first();
            $order = $lecture->order;

            $listOfLectures = Lectures::setEagerLoads([])
                ->where('section_id', $lecture->section_id)
                ->where('order', '>', $order)
                ->select('id', 'order')
                ->get();

            foreach ($listOfLectures as $lec) {
                Lectures::where('id', $lec->id)
                    ->update(['order' => $lec->order - 1]);
            }

            $queryLecture->delete();
        }
    }

    function deleteAsset(Request $request)
    {
        $request->validate([
            'resource_id' => 'required',
            'lecture_id' => 'required',
            'course_id' => 'required'
        ]);

        $course = Course::where('id', $request->input('course_id'))
            ->where('author_id', Auth::user()->id)
            ->first(['id']);
        $lecture = Lectures::find($request->input('lecture_id'), ['id']);

        if (!$course || !$lecture) abort(400);

        Resources::where('id', $request->input('resource_id'))
            ->where('lecture_id', $lecture->id)
            ->delete();

        return Lectures::find(
            $lecture->id,
            ['id', 'size', 'updated_at', 'original_filename']
        );
    }

    function handleVideo(Request $request)
    {
        $rules = [
            'lecture_id' => 'required',
            'course_id' => 'required',
            'video' => 'required|file|mimetypes:video/mp4,video/mpeg'
        ];

        $validator = Validator::make($request->all(), $rules);

        $lecture = Lectures::find($request->input('lecture_id'));

        if ($validator->fails() || empty($lecture))
            return response()->json($validator->errors(), 400);

        $file = $request->file('video');

        $filename = $file->getClientOriginalName();
        $path = $file->store('lesson');
        // $size = Storage::size($path);

        Lectures::where('id', $lecture->id)
            ->update([
                'original_filename' => $filename,
                // 'size' => $size,
                'src' => $path
            ]);

        return Lectures::find(
            $lecture->id,
            ['id', 'updated_at', 'original_filename']
        );
    }

    function handleResources(Request $request)
    {
        $rules = [
            'lecture_id' => 'required',
            'course_id' => 'required',
            'resource' => 'required|file'
        ];

        $validator = Validator::make($request->all(), $rules);

        $lecture = Lectures::find($request->input('lecture_id'));

        if ($validator->fails() || empty($lecture))
            return response()->json($validator->errors(), 400);

        $file = $request->file('resource');

        $filename = $file->getClientOriginalName();
        $path = $file->store('resources');
        // $size = Storage::size($path);

        Resources::create([
            'lecture_id' => $lecture->id,
            'original_filename' => $filename,
            'src' => $path
        ]);

        return Lectures::find(
            $lecture->id,
            ['id', 'size', 'updated_at', 'original_filename']
        );
    }

    function order(Request $request, $type)
    {
        $request->validate(
            [
                'list' => 'required',
                'course_id' => 'required'
            ]
        );

        $course_id = $request->input('course_id');
        $course = Course::select('id')
            ->firstWhere('id', $course_id);

        if (!$course) return abort(400);

        $list = $request->input('list');

        $data = null;
        if ($type == 'section') {
            $data = Sections::select('id')
                ->whereIn('id', $list)
                ->get()
                ->count();
        } elseif ($type == 'lecture') {
            $data = Lectures::select('id')
                ->whereIn('id', $list)
                ->get()
                ->count();
        }

        if (count($list) !== $data) return abort(400);

        for ($i = 0; $i < $data; $i++) {
            $order = $i + 1;

            $type == 'lecture'
                ? Lectures::where('id', $list[$i])
                ->update(['order' => $order])
                : Sections::where('id', $list[$i])
                ->update(['order' => $order]);
        }

        return ['message' => 'success'];
    }
}
