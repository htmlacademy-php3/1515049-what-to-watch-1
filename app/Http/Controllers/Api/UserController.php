<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Responses\SuccessResponse;
use Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
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
     * @param Request $request
     *
     * @return SuccessResponse
     */
    public function update(Request $request): SuccessResponse
    {
        return $this->success([]);
    }
}
