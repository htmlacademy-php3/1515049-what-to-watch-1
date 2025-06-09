<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Responses\SuccessResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Просмотр списка пользователей (???)
     *
     * @param Request $request
     *
     * @return SuccessResponse
     */
    public function index(Request $request) : SuccessResponse
    {
        return $this->success([]);
    }

    /**
     * Просмотр своего профиля
     *
     * @return SuccessResponse
     */
    public function me() : SuccessResponse
    {
        return $this->success([]);
    }

    /**
     * Изменение профиля
     *
     * @param Request $request
     *
     * @return SuccessResponse
     */
    public function  update(Request $request) : SuccessResponse
    {
        return $this->success([]);
    }
}
