<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReplyComment extends Model
{
    use HasFactory;
    protected $table = 'reply_comment';
    protected $fillable = ['comment_id', 'author_id', 'content'];
    protected $with = ['user'];

    public function user()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
