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

        // Standard user (stand worker)
        if ($user->rol === 'user') {
            $stand = Stand::find($user->standId);
            if (!$stand) {
                abort(403, 'No tienes un stand asignado.');
            }

            $recentVisits = Visit::with('participant')
                ->where('standId', $stand->id)
                ->orderBy('created_at', 'desc')
                ->take(50)
                ->get();

            return view('dashboard.stand', compact('stand', 'recentVisits'));
        }

        abort(403, 'Invalid Role');
    }
}
