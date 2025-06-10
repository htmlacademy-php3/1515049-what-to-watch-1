<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request) : JsonResponse
    {
        return response()->json(['message' => 'Список пользователей']);
    }

    public function me() : JsonResponse
    {
        return response()->json(['message' => "Профиль пользователя"]);
    }

    public function  update(Request $request) : JsonResponse
    {
        return response()->json(['message' => 'Успешное изменение!!!']);
    }
}
