<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest\LoginRequest;
use App\Http\Requests\UserRequest\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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

    public function register(RegisterRequest $request) {
        $newUser = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone_number' => $request->input('phoneNumber'),
            'password' => Hash::make($request->input('password')),
            'role_id' => ($request->input('isTutor')) ? 2 : 3
        ]);

        return response()->json([
            'message' => 'Register successfully'
        ]);

    }

    protected function respondWithToken($token) {
        return response()->json([
            'token' => $token,
            'type' => 'bearer',
        ]);
    }
}
