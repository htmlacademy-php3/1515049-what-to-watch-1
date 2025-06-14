<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request) : JsonResponse
    {
        return response()->json(['message' => 'Успешная аутентификация!']);
    }
}
