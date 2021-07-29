<?php

namespace App\Models;

use App\Enums\EProfileFileType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'sex',
        'address',
        'achievement_description',
    ];

    protected $casts = [
        'achievement' => 'array'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function avatars() {
        return $this->morphMany(File::class, 'model')->where('type', EProfileFileType::AVATAR);
    }

    public function avatar() {
        return $this->avatars()->orderBy('created_at', 'desc')->limit(1);
        // return $this->morphOne(File::class, 'model')->latestOfMany('*', 'avatars');
    }

    public function achievements() {
        return $this->morphMany(File::class, 'model')->where('type', EProfileFileType::ACHIEVEMENT);
    }
}
