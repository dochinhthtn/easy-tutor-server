<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PDO;

class User extends Authenticatable {
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function subjects() {
        return $this->belongsToMany(Subject::class, 'users_subjects', 'user_id', 'subject_id');
    }

    public function posts() {
        return $this->hasMany(Post::class, 'user_id');
    }

    public function appliedPosts() {
        return $this->belongsToMany(Post::class, 'applications', 'user_id', 'post_id');
    }

    public function profile() {
        return $this->hasOne(Profile::class, 'user_id');
    }

    public function role() {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function rates() {
        return $this->hasMany(Rate::class, 'tutor_id');
    }
}
