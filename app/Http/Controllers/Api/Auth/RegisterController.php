<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Responses\SuccessResponse;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request) : SuccessResponse
    {
        $params =
            $request->validated();
        $user =
            User::create([
                'name' => $params['name'],
                'email' => $params['email'],
                'password' => Hash::make($params['password']),
            ]);
        $token =
            $user->createToken('auth_token');

        return $this->success([
            'user' => $user,
            'token' => $token->plainTextToken,
        ], 201);
    }
}
