<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        // Usuario NO autenticado → manda a login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Usuario autenticado, pero NO admin → no tiene acceso
        if (Auth::user()->rol !== 'admin') {
            return redirect('/')->with('error', 'Acceso denegado.');
        }

        return $next($request);
    }
}
