<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AutoSaveController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CourseLandingPageController;
use App\Http\Controllers\CoursePriceController;
use App\Http\Controllers\CreateCourseController;
use App\Http\Controllers\CreateSectionController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\FreeEnrollController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\LearningController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MyLearningController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PromotionsController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\SubmitForReviewController;
use App\Http\Controllers\CourseRatifyController;
use App\Http\Controllers\CreateLectureController;
use App\Http\Controllers\CurriculumController;
use App\Http\Controllers\ReviewCourseController;
use App\Http\Controllers\UpdateCurriculumController;
use App\Http\Controllers\UpdateProgressController;
use App\Http\Controllers\OverviewController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\PurchaseHistoryController;
use App\Http\Controllers\SearchController;

Route::get('/payment-successfully', function () {
    return view('pages.payment');
});

Route::get(
    '/',
    [HomeController::class, 'index']
)->name('home');

Route::match(
    ['get', 'post'],
    '/course/{url}',
    [DetailController::class, 'index']
)
    ->name('course');

Route::get('/categories/{url?}', [CategoryController::class, 'index'])->name('category');

Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/get-courses', [CartController::class, 'getCourses']);
Route::post('/applying-coupon', [CartController::class, 'applyingCoupon']);

Route::middleware(['auth'])->group(function () {
    // CHECKOUT
    Route::get('/cart/checkout', [CheckoutController::class, 'checkout']);
    // PURCHASE
    Route::post('/purchase', [PurchaseController::class, 'purchase']);
    Route::get('/purchase-history',[PurchaseHistoryController::class,'purchaseHistory'])
    ->name('purchase-history');
    // ENROLLMENT
    Route::post('/enroll/free-course', [FreeEnrollController::class, 'freeEnroll'])->name('free-enroll');

    Route::get('/my-learning', [MyLearningController::class, 'index'])->name('my-learning');
    Route::get('/view-notifications', [NotificationController::class, 'index'])->name('notification');

    // PROFILE
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'save'])->name('saveProfile');
    Route::post('/change-password', [ProfileController::class, 'changePassword'])
        ->name('changePassword');
    Route::post('/change-bio', [ProfileController::class, 'changeBio'])
        ->name('changeBio');
    Route::post('/upload-avatar', [ProfileController::class, 'uploadAvatar'])
        ->name('uploadAvatar');

    // LOGIN
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::post('/image-upload', [ImageUploadController::class, 'index'])->name('image-upload');

    Route::post('/update-progress', [
        UpdateProgressController::class, 'updateProgress'
    ]);

    Route::prefix('instructor')->group(function () {
        // /instructor/....

        Route::get(
            '/create',
            [CreateCourseController::class, 'index']
        )
            ->name('show-create-course');
        Route::post(
            '/create-course',
            [CreateCourseController::class, 'create']
        )->name('create-course');

        Route::get(
            '/courses',
            [InstructorController::class, 'instructor']
        )->name('instructor-courses');

        // Route::get(
        //     '/manage-course',
        //     [InstructorController::class, 'manageCourse']
        // )->name('instructor-manage');

        Route::get(
            '/course/{id}/basics',
            [CourseLandingPageController::class, 'entryCourse']
        )->name('entry-course');

        Route::get(
            '/course/{id}/curriculum',
            [CurriculumController::class, 'curriculum']
        )->name('curriculum');

        Route::get(
            '/course/{id}/price',
            [CoursePriceController::class, 'price']
        )->name('price');

        Route::post(
            '/course/{id}/price',
            [CoursePriceController::class, 'update_price']
        )->name('update-price');

        Route::match(
            ['get', 'post'],
            '/course/{id}/promotions',
            [PromotionsController::class, 'promotions']
        )->name('promotions');

        Route::get('/overview', [OverviewController::class, 'index'])->name("instructor-overview");
        Route::post(
            '/submit-for-review',
            [SubmitForReviewController::class, 'index']
        )
            ->name('submit-for-review');
    });

    Route::post('/auto-save/{course_id}', [AutoSaveController::class, 'index'])->name('auto-save');

    // SECTION
    Route::post('/create-section', [CreateSectionController::class, 'index']);
    // LETURE
    Route::post('/create-lecture', [CreateLectureController::class, 'index']);
    Route::post('curriculum/update/{type}', [
        UpdateCurriculumController::class, 'updateTitle'
    ]);

    Route::post('/delete-curriculum', [UpdateCurriculumController::class, 'delete']);
    Route::post('/delete-asset', [UpdateCurriculumController::class, 'deleteAsset']);

    Route::prefix('curriculum')->group(function () {
        Route::post(
            '/handle-lecture-video',
            [UpdateCurriculumController::class, 'handleVideo']
        );
        Route::post(
            '/handle-resources',
            [UpdateCurriculumController::class, 'handleResources']
        );
        Route::post(
            '/order/{type}',
            [UpdateCurriculumController::class, 'order']
        );
    });


    // COUPON
    Route::post('/data-coupon', [PromotionsController::class, 'data']);

    Route::post(
        '/create-coupon',
        [PromotionsController::class, 'createCoupon']
    )
        ->name('createCoupon');

    Route::post('/rating', [RatingController::class, 'index'])->name('rating');
});

Route::middleware(['guest'])->group(function () {
    Route::get('/signin', [LoginController::class, 'showLogin'])->name('showLogin');
    Route::get('/signup', [LoginController::class, 'signup'])->name('sign-up');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/create-user', [LoginController::class, 'createUser'])
        ->name('createUser');
});

Route::get(
    '/learning/{url}',
    [LearningController::class, 'index']
)->name('learning')->middleware(['enrollment', 'auth']);

Route::get(
    '/instructor/profile/{slug}',
    [InstructorController::class, 'index']
)->name('instructor');

Route::middleware(['admin'])->group(function () {
    Route::get(
        '/admin/submission-courses-list',
        [
            AdminController::class, 'review'
        ]
    )
        ->name('submission-courses-list');
    Route::post('/admin/course-ratify', [CourseRatifyController::class, 'index'])->name('course-ratify');
});

Route::get('/course/draft/{id}', [ReviewCourseController::class, 'draft'])
    ->name('draft');
// ->middleware(['review-course']);

Route::prefix('performance')->group(function () {
    Route::post('/revenue', [OverviewController::class, 'chartJSYear']);
    Route::post('/enrollments', [OverviewController::class, 'chartEnrollments']);
    Route::post('/rating', [OverviewController::class, 'chartRating']);
    Route::post('/courses', [OverviewController::class, 'chartCourses']);
    Route::post('/instructor', [OverviewController::class, 'chartInstructor']);
});
Route::post('/autocomplete/search', [SearchController::class, 'search']);
Route::get('/search', [SearchController::class, 'index'])->name('search');
