<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Http\JsonResponse;

final class Handler extends ExceptionHandler
{
    /**
     * Список исключений, которые не нужно логировать.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [];

    /**
     * Список полей ввода, которые никогда не будут включены в сообщения об исключениях.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Обработка необработанных исключений.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Обработка не аутентифицированных запросов.
     */
    protected function unauthenticated($request, AuthenticationException $exception): JsonResponse
    {
        return response()->json([
            'message' => 'Unauthenticated',
        ], 401);
    }
}
