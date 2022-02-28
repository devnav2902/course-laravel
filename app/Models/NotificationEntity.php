<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationEntity extends Model
{
    use HasFactory;
    protected $table = 'notification_entity';

    public function notification_course()
    {
        return $this->hasMany(NotificationCourse::class, 'entity_id');
    }
}
