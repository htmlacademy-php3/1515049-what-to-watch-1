<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class LoginService
{
    /**
     * Аутентифицирует пользователя и возвращает токен.
     *
     * @param array $credentials
     * @return string
     */
    public function loginUser(array $credentials): string
    {
        if (!Auth::attempt($credentials)) {
            throw new UnauthorizedHttpException('', 'Неверный email или пароль.');
        }

        /** @var User $user */
        $user = auth()->user();

        if (!$user) {
            throw new UnauthorizedHttpException('', 'Пользователь не найден.');
        }

        return $user->createToken('auth_token')->plainTextToken;
    }
}
