<?php

namespace App\Http\Controllers;


use App\Models\Category;
use App\Models\Course;
use Artesaos\SEOTools\Facades\SEOMeta;

class CategoryController extends Controller
{
    //
    public function index($url = '')
    {

        $categories = Category::with(
            [
                'course' => function ($q) {
                    $q->where('isPublished', 1);
                }
            ]
        )
            ->get(['title', 'id', 'slug']);

        $courses = new Course;
        if ($url === '') {
            SEOMeta::setTitle('Danh mục khóa học');
            
            $courses = $courses::with('category');
            $breadcrumb = 'Courses';
        } else {
            $courses = $courses::with('category')
                ->whereHas('category', function ($q) use ($url) {
                    $q->where("slug", $url);
                });

            $breadcrumb = Category::where('slug', $url)
                ->first(['slug', 'title']);

            if ($breadcrumb) {
                SEOMeta::setTitle($breadcrumb->title);
                $breadcrumb = 'Search: ' . $breadcrumb->title;
            }
        }

        $courses = $courses
            ->where('isPublished', 1)
            ->withAvg('rating', 'rating')
            ->withCount('rating')
            ->withCount('course_bill')
            ->paginate(10, ['*']);

        return view('pages.categories', compact(['categories', 'courses', 'breadcrumb']));
    }
}
