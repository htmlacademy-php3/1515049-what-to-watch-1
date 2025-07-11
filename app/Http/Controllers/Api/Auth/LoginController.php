<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Responses\ErrorResponse;
use App\Http\Responses\SuccessResponse;
use App\Services\AuthService;
use App\Http\Requests\Auth\LoginRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

/**
 * Контроллер входа
 */
class LoginController extends Controller
{
    public function __construct(protected AuthService $authService)
    {
    }

    /**
     * Обработка входа пользователя
     *
     * @param LoginRequest $request
     * @return SuccessResponse|ErrorResponse
     */
    public function login(LoginRequest $request): SuccessResponse|ErrorResponse
    {
        try {
            $token = $this->authService->loginUser($request->validated());

            return $this->success(['token' => $token]);
        } catch (UnauthorizedHttpException $e) {
            return new ErrorResponse(
                message: 'Переданные данные не корректны.',
                errors: [
                    'email' => ['Неверный email или пароль.'],
                    'password' => ['Неверный email или пароль.']
                ],
                statusCode: Response::HTTP_UNAUTHORIZED
            );
        }
    }
}
