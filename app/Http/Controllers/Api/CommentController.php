<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(int $film_id) : JsonResponse
    {
        return response()->json(['message' => "Список отзывов к фильму {$film_id}" ]);
    }

    public function create(Request $request, int $film_id) : JsonResponse
    {
        return  response()->json(['message' => "Добавление отзыва к фильму {$film_id}"]);
    }

    public function update(Request $request, string $comment) : JsonResponse
    {
        return  response()->json(['message' => "Отзыв {$comment} добавлен"]);
    }

    public function delete(string $comment) : JsonResponse
    {
        return  response()->json(['message' => "Отзыв {$comment} удален"]);
    }
}
