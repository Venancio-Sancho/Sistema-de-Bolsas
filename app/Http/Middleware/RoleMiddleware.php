<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Se não estiver autenticado
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Se o role não corresponder
        if (Auth::user()->role !== $role) {
            abort(403, 'Acesso não autorizado');
        }

        return $next($request);
    }
}
