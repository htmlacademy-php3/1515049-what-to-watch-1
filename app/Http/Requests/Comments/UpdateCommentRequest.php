<?php

namespace App\Http\Requests\Comments;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

final class UpdateCommentRequest extends FormRequest
{


    /**
     * @return string[]
     *
     * @psalm-return array{'rate.min': 'Оценка должна быть не менее 1', 'rate.max': 'Оценка должна быть не более 10', 'text.min': 'Комментарий должен содержать не менее 50 символов', 'text.max': 'Комментарий должен содержать не более 400 символов', 'comment_id.exists': 'Родительский комментарий не найден'}
     */
    public function messages(): array
    {
        return [
            'rate.min' => 'Оценка должна быть не менее 1',
            'rate.max' => 'Оценка должна быть не более 10',
            'text.min' => 'Комментарий должен содержать не менее 50 символов',
            'text.max' => 'Комментарий должен содержать не более 400 символов',
            'comment_id.exists' => 'Родительский комментарий не найден'
        ];
    }

    /**
     * @return never
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'message' => 'Ошибки валидации',
                'errors' => $validator->errors()
            ], 422)
        );
    }
}
