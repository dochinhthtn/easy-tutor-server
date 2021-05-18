<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    use HasFactory;

    protected $fillable = [
        'assessor_id',
        'tutor_id',
        'star',
        'comment'
    ];

    public function assessor() {
        return $this->belongsTo(User::class, 'assessor_id');
    }

    public function tutor() {
        return $this->belongsTo(User::class, 'tutor_id');
    }


}
