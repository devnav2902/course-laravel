<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table = 'comment';
    protected $fillable = ['author_id', 'content', 'course_id'];
    protected $with = ['user', 'reply', 'like'];
    protected $withCount = ['like', 'reply'];

    public function user()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
    public function reply()
    {
        return $this->hasMany(ReplyComment::class, 'comment_id');
    }
    public function like()
    {
        return $this->hasMany(Like::class, 'comment_id');
    }
}
