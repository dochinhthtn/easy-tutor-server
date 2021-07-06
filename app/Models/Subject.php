<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name'
    ];
    
    public function posts() {
        return $this->hasMany(Post::class, 'subject_id');
    }

    public function users() {
        return $this->belongsToMany(User::class, 'users_subjects', 'subject_id', 'user_id');
    }
}
