<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $table = 'course';
    protected $fillable = ['author_id', 'title', 'description', 'slug', 'thumbnail', 'video_demo', 'isPublished', 'price', 'discount', 'submit_for_review'];
    protected $with =
    [
        'author',
        'rating',
        'category',
        'course_bill',
        'section',
        'price'
    ];

    function getUpdatedAtAttribute($date)
    {
        return Carbon::parse($date)->isoFormat('MMMM DD, Y');
    }

    function coupon()
    {
        return $this->hasMany(CourseCoupon::class, 'course_id')
            ->where('status', 1);
    }

    function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
    function notification_course()
    {
        return $this->hasMany(NotificationCourse::class, 'course_id');
    }

    function rating()
    {
        return $this->hasMany(Rating::class, 'course_id');
    }
    function category()
    {
        return $this->belongsToMany(Category::class, CategoriesCourse::class, 'course_id', 'category_id',);
    }
    function course_bill()
    {
        return $this->hasMany(CourseBill::class, 'course_id');
    }

    function section()
    {
        return $this->hasMany(Sections::class, 'course_id')->orderBy('order', 'asc');
    }
    function comment()
    {
        return $this->hasMany(Comment::class, 'course_id');
    }
    function lecture()
    {
        return $this->hasManyThrough(Lectures::class, Sections::class, 'course_id', 'section_id');
    }
    function price()
    {
        return $this->belongsTo(Price::class, 'price_id');
    }
}
