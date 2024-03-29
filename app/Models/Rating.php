<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;
    protected $table = 'rating';
    protected $fillable =
    ['user_id', 'course_id', 'content', 'rating'];

    protected $with = ['user'];


    public function getCreatedAtAttribute($date)
    {
        return Carbon::parse($date)->isoFormat('MMMM DD, Y');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
