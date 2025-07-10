<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Responses\ErrorResponse;
use App\Http\Responses\SuccessResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    /**
     * Обработка входа пользователя
     *
     * @param LoginRequest $request
     * @return SuccessResponse|ErrorResponse
     */
    public function login(LoginRequest $request): SuccessResponse|ErrorResponse
    {
        if (!Auth::attempt($request->validated())) {
            return new ErrorResponse(
                message: 'Переданные данные не корректны.',
                errors: [
                    'email' => ['Неверный email или пароль.'],
                    'password' => ['Неверный email или пароль.']
                ],
                statusCode: Response::HTTP_UNAUTHORIZED
            );
        }

        $token = Auth::user()->createToken('auth_token');

        return $this->success([
            'token' => $token->plainTextToken,
        ]);
    }
}
