<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();

        if ($user->rol === 'arrendador') {
            return redirect()->route('arrendador.index');
        }

        if ($user->rol === 'inquilino') {
            return redirect()->route('inquilino.index');
        }
        if ($user->rol === 'admin') {
            return redirect()->route('admin.index');
        }

        return abort(403, 'Rol no válido');
    }
}