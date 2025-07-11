<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Responses\ErrorResponse;
use App\Services\AuthService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogoutController extends Controller
{
    public function __construct(protected AuthService $authService)
    {
    }

    /**
     * Выход из системы (удаление всех токенов пользователя)
     *
     * @param Request $request
     * @return Response|ErrorResponse
     */
    public function logout(Request $request): ErrorResponse|Response
    {
        $user = Auth::user();

        if (!$user) {
            return new ErrorResponse(
                message: 'Пользователь не аутентифицирован.',
                statusCode: Response::HTTP_UNAUTHORIZED
            );
        }

        $this->authService->logoutUser($user);

        return response()->noContent();
    }
}
