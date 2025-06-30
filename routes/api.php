<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\FilmController;
use App\Http\Controllers\Api\GenreController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

// Фильмы
Route::prefix('films')->group(function () {
    Route::get('/', [FilmController::class, 'index']);
    Route::get('/{id}', [FilmController::class, 'show']);
    Route::post('/', [FilmController::class, 'store']);
    Route::patch('/', [FilmController::class, 'update']);
    Route::get('{id}/favorite', [FavoriteController::class, 'show']);
    Route::post('{id}/favorite', [FavoriteController::class, 'store']);
    Route::delete('{id}/favorite', [FavoriteController::class, 'destroy']);
    Route::get('{id}/similar', [FilmController::class, 'similar']);
});

// Избранное
Route::get('/favorite', [FavoriteController::class, 'index']);

// аутентификация
Route::group([], function () {
    Route::post('/register', [RegisterController::class, 'register']);
    Route::post('/login', [LoginController::class, 'login']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [LogoutController::class, 'logout']);
    });
});

// Пользователи
Route::prefix('/user')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [UserController::class, 'me']);
    Route::patch('/', [UserController::class, 'update']);
});

// Жанры
Route::prefix('/genres')->group(function () {
    Route::get('/', [GenreController::class, 'index']);
    Route::patch('/{genre}', [GenreController::class, 'update']);
});

// Комментарии
Route::prefix('/comments')->group(function () {
    Route::get('/{id}', [CommentController::class, 'index']);
    Route::post('/{id}', [CommentController::class, 'store']);
    Route::patch('/{comment}', [CommentController::class, 'update']);
    Route::delete('/{comment}', [CommentController::class, 'destroy']);
});

// Промо
Route::prefix('/promo')->group(function () {
    Route::get('/', [FilmController::class, 'showPromo']);
    Route::post('/{id}', [FilmController::class, 'createPromo']);
});
