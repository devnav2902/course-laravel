<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Sections extends Model
{
    use HasFactory;
    protected $table = 'sections';
    protected $fillable = ['course_id', 'title', 'order'];
    protected $withCount = ['lecture'];

    protected $with = ['lecture', 'resource'];

    public function lecture()
    {
        return $this->hasMany(Lectures::class, 'section_id')
            ->orderBy('order', 'asc');
    }

    public function countProgress()
    {
        return $this->hasManyThrough(Progress::class, Lectures::class, 'section_id', 'lecture_id')
            ->where('user_id', Auth::user()->id)
            ->where('progress', 1);
    }

    public function resource()
    {
        return $this->hasManyThrough(Resources::class, Lectures::class, 'section_id', 'lecture_id');
    }
}
