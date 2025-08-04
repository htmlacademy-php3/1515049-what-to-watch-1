<?php

namespace App\Http\Requests\Comments;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreCommentRequest extends FormRequest
{


    /**
     * @return string[]
     *
     * @psalm-return array{'text.required': 'Текст комментария обязателен', 'text.min': 'Комментарий должен содержать не менее 50 символов', 'text.max': 'Комментарий должен содержать не более 400 символов', 'rate.required': 'Оценка обязательна', 'rate.min': 'Оценка должна быть не менее 1', 'rate.max': 'Оценка должна быть не более 10', 'comment_id.exists': 'Родительский комментарий не найден', 'film_id.required': 'Не указан фильм', 'film_id.exists': 'Указанный фильм не найден'}
     */
    public function messages(): array
    {
        return [
            'text.required' => 'Текст комментария обязателен',
            'text.min' => 'Комментарий должен содержать не менее 50 символов',
            'text.max' => 'Комментарий должен содержать не более 400 символов',
            'rate.required' => 'Оценка обязательна',
            'rate.min' => 'Оценка должна быть не менее 1',
            'rate.max' => 'Оценка должна быть не более 10',
            'comment_id.exists' => 'Родительский комментарий не найден',
            'film_id.required' => 'Не указан фильм',
            'film_id.exists' => 'Указанный фильм не найден'
        ];
    }
}
