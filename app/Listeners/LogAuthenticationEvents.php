<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Log;

class LogAuthenticationEvents
{
    /**
     * Handle successful login events.
     */
    public function handleLogin(Login $event): void
    {
        Log::channel('auth')->info('Inicio de sesión exitoso', [
            'user_id'    => $event->user->id,
            'email'      => $event->user->email,
            'name'       => $event->user->name,
            'role'       => $event->user->role ?? 'N/A',
            'ip'         => request()->ip(),
            'user_agent' => request()->userAgent(),
            'timestamp'  => now()->toDateTimeString(),
        ]);
    }

    /**
     * Handle failed login attempts.
     */
    public function handleFailed(Failed $event): void
    {
        Log::channel('auth')->warning('Intento de inicio de sesión fallido', [
            'email'      => $event->credentials['email'] ?? 'N/A',
            'ip'         => request()->ip(),
            'user_agent' => request()->userAgent(),
            'timestamp'  => now()->toDateTimeString(),
        ]);
    }

    /**
     * Handle logout events.
     */
    public function handleLogout(Logout $event): void
    {
        Log::channel('auth')->info('Cierre de sesión', [
            'user_id'    => $event->user->id ?? 'N/A',
            'email'      => $event->user->email ?? 'N/A',
            'name'       => $event->user->name ?? 'N/A',
            'ip'         => request()->ip(),
            'user_agent' => request()->userAgent(),
            'timestamp'  => now()->toDateTimeString(),
        ]);
    }

    /**
     * Handle lockout events (too many failed attempts).
     */
    public function handleLockout(Lockout $event): void
    {
        Log::channel('auth')->critical('Cuenta bloqueada por demasiados intentos', [
            'email'      => $event->request->input('email', 'N/A'),
            'ip'         => $event->request->ip(),
            'user_agent' => $event->request->userAgent(),
            'timestamp'  => now()->toDateTimeString(),
        ]);
    }
}
