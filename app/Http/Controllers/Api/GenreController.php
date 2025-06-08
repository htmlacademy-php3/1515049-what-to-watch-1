<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function index() : JsonResponse
    {
        return response()->json(['message' => 'Список жанров']);
    }

    public function update(Request $request, $id) : JsonResponse
    {
        return response()->json(['message' => "Обновление жанра {$id}"]);
    }
}
