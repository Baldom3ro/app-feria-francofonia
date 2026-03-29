<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stand;
use App\Models\User;
use App\Models\Participant;
use App\Models\Visit;
use App\Models\Survey;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Admin o Supervisor → dashboard completo
        if ($user->rol === 'admin' || $user->rol === 'supervisor') {
            $totalParticipants = Participant::count();
            $totalVisits = Visit::count();
            $totalSurveys = Survey::count();
            $avgRating = Survey::avg('rating') ?? 0;
            $stands = Stand::with('owner')->get();

            return view('dashboard.admin', compact(
                'totalParticipants',
                'totalVisits',
                'totalSurveys',
                'avgRating',
                'stands'
            ));
        }

        // Usuario de stand
        if ($user->rol === 'user') {
            $stand = Stand::find($user->standId);

            if (!$stand) {
                // En vez de abort(403), redirigir a la página personalizada con mensaje claro
                return redirect()->route('access.denied')
                    ->with('required_roles', 'usuario con stand asignado');
            }

            $recentVisits = Visit::with('participant')
                ->where('standId', $stand->id)
                ->orderBy('created_at', 'desc')
                ->take(50)
                ->get();

            return view('dashboard.stand', compact('stand', 'recentVisits'));
        }

        // Rol no reconocido o NULL → redirigir a 403 personalizada
        return redirect()->route('access.denied')
            ->with('required_roles', 'admin, supervisor o user');
    }
}
