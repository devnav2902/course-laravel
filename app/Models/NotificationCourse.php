<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationCourse extends Model
{
    use HasFactory;
    protected $with = ['course', 'entity'];
    protected $table = 'notification_course';
    protected $fillable = ['course_id', 'entity_id'];

    function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
    function entity()
    {
        return $this->belongsTo(NotificationEntity::class, 'entity_id');
    }
}
