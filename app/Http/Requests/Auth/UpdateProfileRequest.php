<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

final class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:255',
            'email' => [
                'sometimes',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore(Auth::id())
            ],
            'password' => [
                'sometimes',
                'string',
                Password::min(8)
                ->mixedCase()
                ->numbers()
                ->symbols(),
                'confirmed'
            ],
            'avatar' => 'sometimes|image|mimes:jpeg,png,jpg|max:10240',
        ];
    }
}
