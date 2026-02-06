<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StudentAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        // Verifica se o estudante está logado
        if (!session()->has('student')) {
            return redirect()->route('student.login')->with('error', 'Por favor, faça login para continuar.');
        }

        return $next($request);
    }
}
