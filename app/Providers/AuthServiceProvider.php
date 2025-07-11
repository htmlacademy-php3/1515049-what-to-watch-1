<?php

namespace App\Providers;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [];
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('update-comment', function (User $user, Comment $comment) {
            return $user->id === $comment->user_id || (int)$user->role === User::ROLE_MODERATOR;
        });

        Gate::define('delete-comment', function (User $user, Comment $comment) {
            return $user->id === $comment->user_id || (int)$user->role === User::ROLE_MODERATOR;
        });
    }
}
