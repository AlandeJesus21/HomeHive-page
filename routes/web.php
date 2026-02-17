<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PropiedadController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InquilinoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\FavoritoController;
use App\Http\Controllers\AppReviewController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\PropertyController;

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS
|--------------------------------------------------------------------------
*/


Route::get('/auth/google', function () {

    return Socialite::driver('google')->redirect();
});


Route::get('/auth/google/callback', function () {

    $googleUser = Socialite::driver('google')->stateless()->user();

    session([
        'google_user' => [
            'name' => $googleUser->getName(),
            'email' => $googleUser->getEmail(),
            'google_id' => $googleUser->getId(),
            'avatar' => $googleUser->getAvatar(),
        ]
    ]);

    return redirect('/completar');
});



Route::get('/completar', function () {
    return view('auth.completarform');
});


Route::post('/save', function () {

    $google = session('google_user');

    $user = \App\Models\User::create([
        'name' => $google['name'],
        'email' => $google['email'],
        'google_id' => $google['google_id'],
        'avatar' => $google['avatar'],
        'rol' => request('rol'),
        'password' => Hash::make(request('password')),
    ]);

    auth()->login($user);

    return redirect()->route('home');
});






Route::get('/', function () {
    return view('main.index');
})->name('inicio');

Route::view('/acerca', 'main.acerca');
Route::view('/terminos', 'main.terminos');
Route::view('/politicas', 'main.politicas');

// Reseñas de la app (públicas)
Route::get('/comen', [AppReviewController::class, 'main'])
    ->name('app.reviews.main');

Route::get('/appreviews', [AppReviewController::class, 'index'])
    ->name('app.reviews.index');

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::get('/login', [LoginController::class, 'showLoginForm'])
    ->name('login');

Route::get('/olvidaste', [ResetPasswordController:: class, 'showResetForm'])-> name('Resetpass');

Route::post('/login', [LoginController::class, 'login']);

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])
    ->name('register');

Route::post('/register', [RegisterController::class, 'register']);

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('login');
})->middleware(['auth', 'nocache'])->name('logout');

/*
|--------------------------------------------------------------------------
| RUTAS AUTENTICADAS (TODOS LOS ROLES)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'nocache'])->group(function () {

    Route::get('/home', [HomeController::class, 'index'])
        ->name('home');

    // Perfil
    Route::get('/perfil', [UserController::class, 'edit'])
        ->name('perfil');

    Route::put('/upperfil', [UserController::class, 'update'])
        ->name('perfil.update');

    // Reseñas de la app
    Route::post('/app-reviews', [AppReviewController::class, 'store'])
        ->name('app.reviews.store');
});

/*
|--------------------------------------------------------------------------
| INQUILINO
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:inquilino', 'nocache'])->group(function () {

    Route::get('/inquilino', [InquilinoController::class, 'inicio'])
        ->name('inquilino.index');

    Route::get('/inquilino/{id}/vermas', [InquilinoController::class, 'vermas'])
        ->name('inquilino.vermas');

    Route::get('/inquilino/{id}/comentarios', [InquilinoController::class, 'comentarios'])
        ->name('inquilino.comentarios');

    Route::get('/inquilino/favoritos', [InquilinoController::class, 'favoritos'])
        ->name('inquilino.favoritos');

    // Favoritos
    Route::post('/favoritos/{id}/toggle', [FavoritoController::class, 'toggle'])
        ->name('favoritos.toggle');

    Route::delete('/favoritos/{id}/eliminar', function ($id) {
        auth()->user()->favoritos()->detach($id);
        return back();
    })->name('favoritos.eliminar');

    // Reviews de propiedades
    Route::post('/propiedad/{id}/review', [ReviewController::class, 'store'])
        ->name('reviews.store');

    Route::get('/reviews/{review}/edit', [ReviewController::class, 'edit'])
        ->name('reviews.edit');

    Route::put('/reviews/{review}', [ReviewController::class, 'update'])
        ->name('reviews.update');

    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])
        ->name('reviews.destroy');
});

/*
|--------------------------------------------------------------------------
| ARRENDADOR
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:arrendador', 'nocache'])->group(function () {

    Route::get('/arrendador', [PropiedadController::class, 'index'])
        ->name('arrendador.index');

    Route::get('/registerprop', [PropiedadController::class, 'create'])
        ->name('propiedad.create');

    Route::post('/registerprop', [PropiedadController::class, 'store'])
        ->name('propiedad.store');

    Route::get('/editprop/{propiedad}', [PropiedadController::class, 'edit'])
        ->name('propiedad.edit');

    Route::put('/updateprop/{propiedad}', [PropiedadController::class, 'update'])
        ->name('propiedad.update');

    Route::delete('/deleteprop/{propiedad}', [PropiedadController::class, 'destroy'])
        ->name('propiedad.destroy');

    Route::get('/propiedad/{propiedad}/download-image', [PropiedadController::class, 'downloadImage'])
        ->name('propiedad.download-image');

    Route::get('/arrendador/propiedad/{id}/reviews', [PropiedadController::class, 'viewreviews'])
        ->name('arrendador.reviews');

    Route::get('/comentario', [AppReviewController::class, 'mainarren'])
        ->name('app.reviews.arrendador');
});

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin', 'nocache'])->group(function () {
        Route::get('/admin', [AdminController::class, 'indexad'])
        ->name('admin.index');

    Route::prefix('usuarios')->group(function () {
        Route::get('/index', [UserController::class, 'index'])->name('user.index');
        Route::get('{id}/edit', [UserController::class, 'editar'])->name('user.edit');
        Route::put('{id}', [UserController::class, 'actualizar'])->name('user.update');
        Route::delete('{id}', [UserController::class, 'eliminar'])->name('user.destroy');
        Route::get('/reporteuser', [AdminController::class, 'reporteuser']);

    });


    Route::prefix('propiedades')->group(function () {
        Route::get('/admin/propiedades', [PropertyController::class, 'index'])
            ->name('properties.index');

        Route::get('{id}/edit', [PropertyController::class, 'edit'])
            ->name('properties.edit');

        Route::put('{id}', [PropertyController::class, 'update'])
            ->name('properties.update');

        Route::delete('{id}', [PropertyController::class, 'destroy'])
            ->name('properties.destroy');

        Route::get('/reporte', [PropertyController::class, 'reporte']);



        });

    });