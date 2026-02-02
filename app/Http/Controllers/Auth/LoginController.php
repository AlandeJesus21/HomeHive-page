<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Redirección dinámica después del login
     */
    public function redirectTo()
    {
        // Guardar tipo de usuario en la sesión
        session(['tipo_usuario' => Auth::user()->tipo_usuario]);

        // Redirigir según el tipo de usuario
        if (Auth::user()->tipo_usuario === 'arrendador') {
            return route('arr.index');
        }

        if (Auth::user()->tipo_usuario === 'inquilino') {
            return route('inq.index');
        }

        // Si por alguna razón no coincide, redirige a home
        return '/home';
    }

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    
}