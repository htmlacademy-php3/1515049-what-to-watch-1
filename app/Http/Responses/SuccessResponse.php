<?php

namespace App\Http\Responses;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;

final class SuccessResponse extends BaseResponse
{
    /**
     * Формирование содержимого ответа
     *
     * @return array|null
     */
    protected function makeResponseData(): ?array
    {
        if ($this->data instanceof LengthAwarePaginator) {
            $items =
                $this->data->items();

            if ($items instanceof JsonResource) {
                $items =
                    $items->resolve();
            }

            return [
                'data' => $items,
                'current_page' => $this->data->currentPage(),
                'first_page_url' => $this->data->url(1),
                'next_page_url' => $this->data->nextPageUrl(),
                'prev_page_url' => $this->data->previousPageUrl(),
                'per_page' => $this->data->perPage(),
                'total' => $this->data->total(),
            ];
        }

        if ($this->data instanceof JsonResource) {
            return [
                'data' => $this->data->resolve(),
            ];
        }

        return [
            'data' => $this->prepareData(),
        ];
    }
}
