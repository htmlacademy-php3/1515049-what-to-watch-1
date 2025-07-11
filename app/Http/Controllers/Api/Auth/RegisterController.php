<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Responses\SuccessResponse;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Support\Facades\Hash;

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
        $params = $request->safe()->except('file');

        $result = $this->authService->registerUser($params);

        return $this->success($result, 201);
    }
}
