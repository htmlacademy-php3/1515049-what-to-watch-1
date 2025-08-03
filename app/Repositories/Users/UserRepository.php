<?php

namespace App\Repositories\Users;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Репозиторий для работы с пользователями.
 */
final class UserRepository implements UserRepositoryInterface
{
    /**
     * Найти пользователя по email
     *
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    /**
     * Обновляет данные пользователя по ID.
     *
     * @param  int   $userId   Идентификатор пользователя.
     * @param  array $details  Ассоциативный массив с обновляемыми данными.
     * @return User            Обновлённая модель пользователя.
     *
     * @throws ModelNotFoundException Если пользователь не найден.
     */
    public function updateUser(int $userId, array $details): User
    {
        $user = User::findOrFail($userId);
        $user->update($details);

        return $user->fresh();
    }
}
