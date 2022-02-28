<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Course;
use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        View::composer('*', function ($view) {
            $categories = Category::all();

            $user  = null;
            $notificationCourse = null;
            if (Auth::check()) {
                $user = User::withOnly('bio')
                    ->select('id', 'avatar', 'fullname', 'slug', 'role_id', 'email')
                    ->firstWhere('id', Auth::user()->id);

                $notificationCourse = Course::has('notification_course')
                    ->withOnly('notification_course')
                    ->where('author_id', Auth::user()->id)
                    ->select('id', 'title', 'slug', 'author_id')
                    ->get();
            }

            $view->with(
                [
                    'globalUser' => $user,
                    'globalCategories' => $categories,
                    'globalNotificationCourse' => $notificationCourse
                ]
            );
        });
    }
}
