<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Validation\Validator;
use stdClass;
use Symfony\Component\HttpFoundation\Response;

class ErrorResponse extends BaseResponse
{
    public int $statusCode = Response::HTTP_BAD_REQUEST;

    /**
     * @param string                    $message
     * @param array|Arrayable|Validator $errors
     * @param int                       $statusCode
     * @param bool                      $showErrors
     */
    public function __construct(
        string $message,
        protected array|Arrayable|Validator $errors = [],
        int $statusCode = Response::HTTP_BAD_REQUEST,

    ) {
        parent::__construct([], $statusCode);
        $this->message = $message;
        $this->statusCode = $statusCode;
    }

    /**
     * Формирование содержимого ответа
     *
     * @return (Arrayable|Validator|array|mixed|stdClass)[]
     *
     * @psalm-return array{message: mixed, errors: Arrayable|Validator|array|stdClass}
     */
    protected function makeResponseData(): array
    {
        return [
            'message' => $this->message,
            'errors' => $this->errors ?: new stdClass(),
        ];
    }
}
