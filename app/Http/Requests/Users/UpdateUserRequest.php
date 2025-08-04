<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

/**
 * Запрос на обновление данных пользователя.
 *
 * Валидация включает:
 * — имя (опционально, строка, до 255 символов),
 * — email (опционально, корректный, уникальный, до 255 символов),
 * — пароль (опционально, подтверждён, от 8 символов, со строчными/прописными, цифрами и символами),
 * — аватар (опционально, изображение JPEG/PNG/JPG, до 10 МБ).
 */
class UpdateUserRequest extends FormRequest
{

}
