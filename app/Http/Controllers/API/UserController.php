<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest\UpdateProfileRequest;

class UserController extends Controller {
    //

    public function updateSubject() {

    }

    public function updateProfile(UpdateProfileRequest $request) {
        return "update";
    }

    public function getProfile(User $user) {

    }
}
