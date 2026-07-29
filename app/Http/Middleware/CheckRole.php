<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        // Si el rol del usuario no está en la lista de roles permitidos
        if (!in_array(auth()->user()->role, $roles)) {
            if (auth()->user()->role === 'cajero') {
                return redirect('/pos')->with('error', 'Acceso Denegado: No tienes permisos de administrador.');
            }
            return redirect('/')->with('error', 'Acceso Denegado.');
        }

        return $next($request);
    }
}
