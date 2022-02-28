<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'category';
    protected $fillable = ['title', 'isPublished', 'slug'];
    public  function course()
    {
        return $this->belongsToMany(Course::class, CategoriesCourse::class, 'category_id', 'course_id');
    }
}
