<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $casts = [
        'achivements' => 'array'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}