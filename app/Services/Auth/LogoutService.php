<?php

namespace App\Services\Auth;

use App\Models\User;

class LogoutService
{
    /**
     * Выход пользователя — удаляет все его токены.
     *
     * @param User $user
     * @return void
     */
    public function logoutUser(User $user): void
    {
        $user->tokens()->delete();
    }
}
