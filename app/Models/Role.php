<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $table = 'role';
    protected $fillable = ['name'];
    public $timestamps = false;

    function user()
    {
        return $this->hasOne(User::class, 'role_id');
    }
}
