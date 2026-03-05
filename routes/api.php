<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FavoritoController;
use App\Http\Controllers\Api\PropiedadController;
use App\Http\Controllers\Api\ReviewApiController;
use App\Http\Controllers\Api\AppReviewApiController;

// ======================================================
// RUTAS PÚBLICAS
// ======================================================

// Registro y login
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/user/update', [AuthController::class, 'update']);

// Listar propiedades (público)
Route::get('/propiedades', [PropiedadController::class, 'index']);

// Ver propiedad específica (público)
Route::get('/propiedades/{propiedad}', [PropiedadController::class, 'show']);

// ======================================================
// REVIEWS DE PROPIEDADES (solo lectura - público)
// ======================================================
Route::get('/propiedades/{idPropiedad}/reviews', [ReviewApiController::class, 'index']);
Route::get('/reviews/{id}', [ReviewApiController::class, 'show']);

// ======================================================
// REVIEWS DE LA APP (solo lectura - público)
// ======================================================
Route::get('/appreviews', [AppReviewApiController::class, 'index']);
Route::get('/appreviews/{id}', [AppReviewApiController::class, 'show']);


// ======================================================
// RUTAS PROTEGIDAS (TOKEN SANCTUM)
// ======================================================
Route::middleware('auth:sanctum')->group(function () {

    // Perfil
    Route::get('/me', [AuthController::class, 'me']);

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/logout-all', [AuthController::class, 'logoutAll']);

    // --------------------------------------------------
    // PROPIEDADES (CRUD)
    // --------------------------------------------------
    Route::post('/propiedades', [PropiedadController::class, 'store']);
    Route::put('/propiedades/{propiedad}', [PropiedadController::class, 'update']);
    Route::delete('/propiedades/{propiedad}', [PropiedadController::class, 'destroy']);

    // --------------------------------------------------
    // FAVORITOS
    // --------------------------------------------------
    Route::get('/favoritos', [FavoritoController::class, 'index']);
    Route::post('/favoritos/{id}/toggle', [FavoritoController::class, 'toggle']);
    Route::delete('/favoritos/{id}', [FavoritoController::class, 'eliminar']);

    // --------------------------------------------------
    // REVIEWS DE PROPIEDADES (CRUD)
    // --------------------------------------------------
    Route::post('/propiedades/{idPropiedad}/reviews', [ReviewApiController::class, 'store']);
    Route::put('/reviews/{id}', [ReviewApiController::class, 'update']);
    Route::delete('/reviews/{id}', [ReviewApiController::class, 'destroy']);

    // --------------------------------------------------
    // REVIEWS DE LA APP (CRUD)
    // --------------------------------------------------
    Route::post('/app-reviews', [AppReviewApiController::class, 'store']);
    Route::put('/app-reviews/{id}', [AppReviewApiController::class, 'update']);
    Route::delete('/app-reviews/{id}', [AppReviewApiController::class, 'destroy']);

    Route::get('/viewrent', [PropiedadController::class, 'viewrent']);

});