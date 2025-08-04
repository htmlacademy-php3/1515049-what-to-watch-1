<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin User
 *
 * Ресурс пользователя для API-ответов.
 */
final class UserResource extends JsonResource
{
    /**
     * Преобразует ресурс в массив для JSON-ответа.
     *
     * @param Request $request
     *
     * @return (int|null|string)[]
     *
     * @psalm-return array{name: string, email: string, avatar: null|string, role: int}
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'avatar' => $this->avatar,
            'role' => $this->role,
        ];
    }
}
