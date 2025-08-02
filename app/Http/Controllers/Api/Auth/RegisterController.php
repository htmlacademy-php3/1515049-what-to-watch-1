<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Responses\SuccessResponse;
use App\Services\AuthService;
use Log;

/**
 * Контроллер регистрации пользователя
 */
class RegisterController extends Controller
{
    public function __construct(protected AuthService $authService)
    {

    }

    /**
     * Регистрирует нового пользователя и возвращает токен.
     *
     * @param RegisterRequest $request
     *
     * @return SuccessResponse
     */
    public function register(RegisterRequest $request): SuccessResponse
    {
        $params = $request->validated();

        $result = $this->authService->registerUser($params);

        return $this->success($result, 201);
    }
}
