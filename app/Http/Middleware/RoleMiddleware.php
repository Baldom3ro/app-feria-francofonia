<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware de Roles
 *
 * Valida que el usuario autenticado tenga uno de los roles permitidos.
 * Si no está autenticado → redirige al login.
 * Si no tiene el rol requerido → redirige a página de acceso denegado.
 */
class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles  Roles permitidos (ej: 'admin', 'supervisor')
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Verificar autenticación
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('status', 'Debes iniciar sesión para acceder.');
        }

        // 2. Verificar que el usuario esté activo
        if (!Auth::user()->active) {
            Auth::logout();
            return redirect()->route('login')
                ->withErrors(['email' => 'Tu cuenta ha sido desactivada. Contacta al administrador.']);
        }

        // 3. Verificar rol
        if (!in_array(Auth::user()->rol, $roles)) {
            // Redirigir a página 403 personalizada en lugar de abortar genéricamente
            return redirect()->route('access.denied')
                ->with('required_roles', implode(', ', $roles));
        }

        return $next($request);
    }
}
