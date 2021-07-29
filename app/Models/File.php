<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'path',
        'type',
        'model_id',
        'model_type',
        'user_id'
    ];

    public function model() {
        return $this->morphTo();
    }
}
