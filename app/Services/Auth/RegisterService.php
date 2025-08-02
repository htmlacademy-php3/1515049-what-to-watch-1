<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterService
{
    /**
     * Регистрирует нового пользователя и создаёт токен.
     *
     * @param array $params
     * @return array{user: User, token: string}
     */
    public function registerUser(array $params): array
    {
        $user = User::create([
            'name' => $params['name'],
            'email' => $params['email'],
            'password' => Hash::make($params['password']),
        ]);

        $token = $user->createToken('auth_token');

        return [
            'token' => $token->plainTextToken,
        ];
    }
}
