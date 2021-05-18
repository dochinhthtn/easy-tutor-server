<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject {
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'password',
        'role_id',
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

    public function conversations() {
        return $this->belongsToMany(Conversation::class, 'conversations_users', 'user_id', 'conversation_id');
    }

    public function checkRole(string $roleName) {
        $roles = ["admin" => 1, "tutor" => 2, "user" => 3];
        return $roles[strtolower($roleName)] == $this->role_id;
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier() {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }
}
