<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subject_id',
        'description',
        'address',
        'offer',
        'tutor_id'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tutor() {
        return $this->belongsTo(User::class, 'tutor_id');
    }

    public function applicants() {
        return $this->belongsToMany(User::class, 'applications', 'post_id', 'user_id');
    }

    public function subject() {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function comments() {
        return $this->hasMany(Comment::class, 'post_id');
    }
}
