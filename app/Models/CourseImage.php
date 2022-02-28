<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseImage extends Model
{
    use HasFactory;
    protected $table = 'course_image';
    protected $fillable = ['course_id', 'name_image', 'src', 'isBackground'];
    public $timestamps = false;
}
