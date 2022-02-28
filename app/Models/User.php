<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $table = 'users';


    protected $with = [
        'role',
        'bio',
        'enrollment'
    ];

    protected $fillable = [
        'name',
        'fullname',
        'slug',
        'email',
        'password',
        'avatar',
        'email_verified_at',
        'trangthai_taikhoan',
        'role_id',
        'created_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function course()
    {
        return $this->hasMany(Course::class, 'author_id');
    }

    public function rating()
    {
        return $this->belongsToMany(Course::class, Rating::class, 'user_id', 'course_id');
    }

    public function enrollment()
    {
        return $this->hasMany(CourseBill::class, 'user_id');
    }

    function bio()
    {
        return $this->hasOne(Bio::class, 'user_id');
    }

    function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
    function like()
    {
        return $this->hasMany(Like::class, 'user_id');
    }
}
