<?php

namespace App\Http\Controllers;

use App\Http\Responses\SuccessResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Symfony\Component\HttpFoundation\Response;

abstract class Controller
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    /**
     * Возвращает успешный JSON-ответ с заданными данными и HTTP-статусом.
     *
     * @param mixed    $data       Данные, которые нужно вернуть в ответе
     * @param int|null $statusCode HTTP-код ответа (по умолчанию 200 OK)
     *
     * @return SuccessResponse Объект успешного ответа
     */
    protected function success(mixed $data, ?int $statusCode = Response::HTTP_OK): SuccessResponse
    {
        return new SuccessResponse($data, $statusCode);
    }
}
