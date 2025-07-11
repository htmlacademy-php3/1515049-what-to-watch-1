<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

final class UpdateCommentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'text' => 'string|min:50|max:400',
            'rate' => 'integer|min:1|max:10',
            'comment_id' => 'nullable|exists:comments,id'
        ];
    }

    public function messages(): array
    {
        return [
            'rate.min' => 'Оценка должна быть не менее 1',
            'rate.max' => 'Оценка должна быть не более 10',
            'text.min' => 'Комментарий должен содержать не менее 50 символов',
            'text.max' => 'Комментарий должен содержать не более 400 символов'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422)
        );
    }
}
