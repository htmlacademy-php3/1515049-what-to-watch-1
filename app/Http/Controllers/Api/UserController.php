<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Http\Responses\SuccessResponse;
use App\Repositories\Users\UserRepository;
use Auth;

class UserController extends Controller
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    /**
     * Просмотр своего профиля
     *
     * @return SuccessResponse
     */
    public function me(): SuccessResponse
    {
        $user = Auth::user();
        return $this->success(new UserResource($user));
    }

    /**
     * Изменение профиля
     *
     * @param UpdateUserRequest $request
     *
     * @return SuccessResponse
     */
    public function update(UpdateUserRequest $request): SuccessResponse
    {
        $user = $this->userRepository->updateUser(
            Auth::id(),
            $request->validated()
        );

        return $this->success(new UserResource($user));
    }
}
