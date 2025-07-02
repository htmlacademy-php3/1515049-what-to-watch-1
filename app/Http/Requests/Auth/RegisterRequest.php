<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                $this->getUniqRule(),
            ],
            'password' => [
                $this->getPasswordRequiredRule(),
                'string',
                'min:8'
            ],
        ];
    }

    private function getUniqRule()
    {
        $rule = Rule::unique(User::class);

        if ($this->isMethod('PATCH') && Auth::check()) {
            return $rule->ignore(Auth::user());
        }

        return $rule;
    }

    private function getPasswordRequiredRule() : string
    {
        return $this->isMethod('PATCH') ? 'sometimes' : 'required';
    }
}
