<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index() : JsonResponse
    {
        return response()->json(['message' => 'Список избранного']);
    }

    public function store(Request $request) : JsonResponse
    {
        return response()->json(['message' => "Добавлено в избранное"]);
    }

    public function destroy(Request $request) : JsonResponse
    {
        return response()->json(['message' => "Удаление из избранного"]);

    }
}
