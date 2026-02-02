<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PropiedadController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InquilinoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\FavoritoController;
use App\Http\Controllers\AppReviewController;
use App\Http\Controllers\PropertyController;
use App\Http\Middleware\AdminMiddleware;

// --- RUTAS PÚBLICAS ---
Route::get('/', function () {
    return view('main.index');
})->name('inicio');

Route::view('/acerca', 'main.acerca');


// Arrendador/Inquilino: permite enviar reseñas
    

// Enviar reseñas (solo usuarios autenticados)

Route::post('/app-reviews', [AppReviewController::class, 'store'])
    ->middleware('auth')
    ->name('app.reviews.store');

// Inquilino vistas públicas
Route::view('/detalle', 'inquilino.detalle');
Route::view('/reserva', 'inquilino.reservas');

// Admin vistas públicas
Route::view('/admin/propiedades', 'admin.propiedades');
Route::view('/admin/reporte', 'admin.reporte');
Route::view('/admin/perfil', 'admin.perfil');

// --- AUTH WEB ---
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);

Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// Logout sesión web
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->middleware('auth')->name('logout');

// --- RUTAS PROTEGIDAS ---
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Propiedades
    Route::get('/arrendador', [PropiedadController::class, 'index'])->name('arrendador.index');
    Route::get('/registerprop', [PropiedadController::class, 'create'])->name('propiedad.create');
    Route::post('/registerprop', [PropiedadController::class, 'store'])->name('propiedad.store');
    Route::get('/editprop/{propiedad}', [PropiedadController::class, 'edit'])->name('propiedad.edit');
    Route::put('/updateprop/{propiedad}', [PropiedadController::class, 'update'])->name('propiedad.update');
    Route::delete('/deleteprop/{propiedad}', [PropiedadController::class, 'destroy'])->name('propiedad.destroy');
    Route::get('/propiedad/{propiedad}/download-image', [PropiedadController::class, 'downloadImage'])
        ->name('propiedad.download-image');
    Route::get('/arrendador/propiedad/{id}/reviews', [PropiedadController::class, 'viewreviews'])
     ->name('arrendador.reviews');


    // Inquilino
    Route::get('/inquilino', [InquilinoController::class, 'inicio'])->name('inquilino.index');
    Route::get('/inquilino/{id}/vermas', [InquilinoController::class, 'vermas'])->name('inquilino.vermas');
    Route::get('/inquilino/{id}/comentarios', [InquilinoController::class, 'comentarios'])->name('inquilino.comentarios');
    Route::get('/inquilino/favoritos', [InquilinoController::class, 'favoritos'])->name('inquilino.favoritos');

    // Favoritos
    Route::post('/favoritos/{id}/toggle', [FavoritoController::class, 'toggle'])->name('favoritos.toggle');
    Route::delete('/favoritos/{id}/eliminar', function ($id) {
        auth()->user()->favoritos()->detach($id);
        return back();
    })->name('favoritos.eliminar');

    // Reviews de propiedades
    Route::post('/propiedad/{id}/review', [ReviewController::class, 'store'])->name('reviews.store');

    // Perfil
    Route::get('/perfil', [UserController::class, 'edit'])->name('perfil');
    Route::put('/upperfil', [UserController::class, 'update'])->name('perfil.update');

        // Usuarios vista admin
    Route::prefix('usuarios')->group(function () {
        Route::get('/index', [UserController::class, 'index'])->name('user.index');
        Route::get('{id}/edit', [UserController::class, 'editar'])->name('user.edit');
        Route::put('{id}', [UserController::class, 'actualizar'])->name('user.update');
        Route::delete('{id}', [UserController::class, 'eliminar'])->name('user.destroy');
    });

        //admin rutas protegidas
    Route::get('/admin', [AdminController::class, 'indexad'])->name('admin.index');
    Route::prefix('propiedades')->group(function () {
    Route::get('/admin/propiedades', [PropertyController::class, 'index'])->name('properties.index');
    Route::get('{id}/edit', [PropertyController::class, 'edit'])->name('properties.edit');
    Route::put('{id}', [PropertyController::class, 'update'])->name('properties.update');
    Route::delete('{id}', [PropertyController::class, 'destroy'])->name('properties.destroy');
    });
});


Route::get('/appreviews', [AppReviewController::class, 'index'])
    ->name('app.reviews.index');

// Mostrar reseñas de la app (sección pública/main)
Route::get('/comen', [AppReviewController::class, 'main'])
    ->name('app.reviews.main');

// Guardar reseña de la app
Route::post('/app-reviews', [AppReviewController::class, 'store'])
    ->middleware('auth')
    ->name('app.reviews.store');

Route::get('/comentario', [AppReviewController::class, 'mainarren'])
    ->middleware('auth') 
    ->name('app.reviews.arrendador');