<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Responses\ErrorResponse;
use App\Services\Auth\LogoutService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Контроллер выхода пользователя из системы
 */
class LogoutController extends Controller
{
    public function __construct(protected LogoutService $logoutService)
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
        $user = $request->user();

        if (!$user) {
            return new ErrorResponse(
                message: 'Пользователь не аутентифицирован.',
                statusCode: Response::HTTP_UNAUTHORIZED
            );
        }

        $this->logoutService->logoutUser($user);

        return response()->noContent();
    }
}
