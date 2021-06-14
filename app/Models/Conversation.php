<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function users() {
        return $this->belongsToMany(User::class, 'conversations_users', 'conversation_id', 'user_id');
    }

    public function messages() {
        return $this->hasMany(Message::class, 'conversation_id');
    }

    public function hasUser(User $user) {
        $count = $this->users()->wherePivot('user_id', '=', $user->id)->get()->count();
        return $count > 0;
    }

}
