<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest\LoginRequest;

class AuthController extends Controller {
    //
    public function login(LoginRequest $request) {
        if ($token = auth()->attempt($request->only(['email', 'password']))) {
            return $this->respondWithToken($token);
        }

        return response()->json([
            'login' => 'Your email or password is not correct'
        ], 401);
    }

    public function register() {

    }

    protected function respondWithToken($token) {
        return response()->json([
            'token' => $token,
            'type' => 'bearer',
        ]);
    }
}
