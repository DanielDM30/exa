<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\SkinUploadController;
use App\Http\Controllers\SkinController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TagController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Rutas públicas: no requieren autenticación
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Ruta para subir la skin
Route::match(['POST', 'OPTIONS'], '/upload-skin', [SkinUploadController::class, 'store']);

// Ruta pública para obtener tags
Route::get('/tags', [TagController::class, 'index']);

// Ruta pública para obtener las categorias
Route::get('/categories', [CategoryController::class, 'index']);

// Ruta pública para ver comentarios
Route::get('/skins/{id}/comments', [CommentController::class, 'index']);

// Rutas protegidas: solo accesibles para usuarios autenticados
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Favoritos (movidas arriba pero manteniendo la ruta original)
    Route::get('/favorites', [FavoriteController::class, 'index']); // Nueva ruta
    Route::get('/skins/favorites', [FavoriteController::class, 'index']); // Mantener la ruta original
    Route::post('/skins/{id}/toggle-favorite', [FavoriteController::class, 'toggle']);

    // Ruta para toggle de reacciones
    Route::post('/skins/{id}/toggle-reaction/{type}', [SkinController::class, 'toggleReaction']);

    // Skins
    Route::post('/skins', [SkinController::class, 'store']);
    Route::post('/skins/{id}/like', [SkinController::class, 'like']);
    Route::post('/skins/{id}/dislike', [SkinController::class, 'dislike']);
    Route::delete('/skins/{id}', [SkinController::class, 'destroy']);

    // Comentarios
    Route::post('/comments', [CommentController::class, 'store']);
    Route::delete('/comments/{id}', [CommentController::class, 'destroy']);
});

// Rutas públicas de skins
Route::get('/skins', [SkinController::class, 'index']); // Listar todas las skins
Route::get('/skins/{id}', [SkinController::class, 'show']); // Ver una skin específica
Route::get('/skin-image/{filename}', [SkinController::class, 'getImage']);
