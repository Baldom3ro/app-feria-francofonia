<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Jenssegers\Agent\Agent;

/**
 * Controlador de Gestión de Sesiones Activas
 *
 * Permite al usuario autenticado:
 *  - Ver todas sus sesiones activas (dispositivo, IP, última actividad)
 *  - Cerrar una sesión específica por ID
 *  - Cerrar todas las sesiones excepto la actual
 *
 * Consulta directamente la tabla `sessions` (SESSION_DRIVER=database).
 */
class SessionManagerController extends Controller
{
    /**
     * Lista las sesiones activas del usuario autenticado.
     * Se inyecta en el perfil, no tiene vista propia.
     *
     * @return array  Colección de sesiones enriquecidas
     */
    public static function getActiveSessions(Request $request): array
    {
        $userId = $request->user()->id;
        $currentSessionId = $request->session()->getId();

        // Obtener todas las sesiones del usuario desde la tabla sessions
        $sessions = DB::table('sessions')
            ->where('user_id', $userId)
            ->orderByDesc('last_activity')
            ->get();

        return $sessions->map(function ($session) use ($currentSessionId) {
            // Parsear User Agent para mostrar dispositivo/navegador legible
            $agent = new \stdClass();
            $ua = $session->user_agent ?? '';

            // Detección básica de dispositivo sin librería externa
            $device   = self::parseDevice($ua);
            $browser  = self::parseBrowser($ua);
            $platform = self::parsePlatform($ua);

            return [
                'id'            => $session->id,
                'ip_address'    => $session->ip_address ?? 'Desconocida',
                'device'        => $device,
                'browser'       => $browser,
                'platform'      => $platform,
                'last_activity' => $session->last_activity
                    ? \Carbon\Carbon::createFromTimestamp($session->last_activity)->diffForHumans()
                    : 'Nunca',
                'is_current'    => $session->id === $currentSessionId,
            ];
        })->toArray();
    }

    /**
     * Cierra una sesión específica por su ID.
     * Sólo puede cerrar sesiones del propio usuario autenticado.
     */
    public function destroy(Request $request, string $sessionId): RedirectResponse
    {
        $userId = $request->user()->id;
        $currentSessionId = $request->session()->getId();

        // Seguridad: no permitir cerrar la sesión actual por esta ruta
        // (eso se hace con logout normal)
        if ($sessionId === $currentSessionId) {
            return back()->with('session_error', 'Para cerrar la sesión actual, usa el botón de Cerrar Sesión.');
        }

        // Eliminar solo si pertenece al usuario autenticado
        $deleted = DB::table('sessions')
            ->where('id', $sessionId)
            ->where('user_id', $userId)
            ->delete();

        if ($deleted) {
            return back()->with('session_success', 'Sesión cerrada correctamente.');
        }

        return back()->with('session_error', 'No se pudo cerrar la sesión o no te pertenece.');
    }

    /**
     * Cierra todas las sesiones del usuario excepto la actual.
     */
    public function destroyOthers(Request $request): RedirectResponse
    {
        $userId = $request->user()->id;
        $currentSessionId = $request->session()->getId();

        DB::table('sessions')
            ->where('user_id', $userId)
            ->where('id', '!=', $currentSessionId)
            ->delete();

        return back()->with('session_success', 'Todas las demás sesiones han sido cerradas.');
    }

    // -------------------------------------------------------------------------
    // Helpers privados de parseo de User-Agent (sin dependencia externa)
    // -------------------------------------------------------------------------

    private static function parseDevice(string $ua): string
    {
        if (preg_match('/Mobile|Android|iPhone|iPad/i', $ua)) {
            if (preg_match('/iPad/i', $ua)) return 'Tablet';
            return 'Móvil';
        }
        return 'Computadora';
    }

    private static function parseBrowser(string $ua): string
    {
        $browsers = [
            'Edg'     => 'Edge',
            'OPR'     => 'Opera',
            'Chrome'  => 'Chrome',
            'Firefox' => 'Firefox',
            'Safari'  => 'Safari',
            'MSIE'    => 'Internet Explorer',
            'Trident' => 'Internet Explorer',
        ];
        foreach ($browsers as $key => $name) {
            if (str_contains($ua, $key)) return $name;
        }
        return 'Navegador desconocido';
    }

    private static function parsePlatform(string $ua): string
    {
        $platforms = [
            'Windows NT' => 'Windows',
            'Macintosh'  => 'macOS',
            'Linux'      => 'Linux',
            'Android'    => 'Android',
            'iPhone'     => 'iOS',
            'iPad'       => 'iPadOS',
        ];
        foreach ($platforms as $key => $name) {
            if (str_contains($ua, $key)) return $name;
        }
        return 'Plataforma desconocida';
    }
}
