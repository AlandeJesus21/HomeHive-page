<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <--- importante

class SecurityMiddleware
{
    public function handle(Request $request, Closure $next, $action = null)
    {
        if ($action === 'auth' && !Auth::check()) {
            return redirect('/login');
        }

        return $next($request);
    }
}