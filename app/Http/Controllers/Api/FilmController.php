<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FilmController extends Controller
{
    public function index() : JsonResponse
    {
        return response()->json(['message' => 'Список фильмов']);
    }

    public function show(int $id) : JsonResponse
    {
        return response()->json(['message' => "инфо о фильме {$id}"]);
    }

    public function store(Request $request) : JsonResponse
    {
        return response()->json(['message' => 'Добавлен фильм']);
    }

    public function update(Request $request, int $id) : JsonResponse
    {
        return response()->json(['message' => 'Обновление инфо о фильме']);
    }

    public function similar(int $id) : JsonResponse
    {
        return response()->json(['message' => 'Список похожих фильмов']);
    }

    public function showPromo() : JsonResponse
    {
        return response()->json(['message' => 'просмотр промо']);
    }

    public function createPromo(Request $request, $film_id) : JsonResponse
    {
        return response()->json(['message' => "создание промо фильма {id}"]);
    }
}
