<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

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
}
