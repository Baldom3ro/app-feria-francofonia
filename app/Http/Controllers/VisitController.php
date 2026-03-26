<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visit;
use App\Models\Stand;
use App\Models\Participant;
use Illuminate\Support\Facades\DB;

class VisitController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'standId' => 'required|exists:stands,id',
            'participantId' => 'required|exists:participants,id',
        ]);

        $stand = Stand::findOrFail($request->standId);
        $participant = Participant::findOrFail($request->participantId);

        // Validar duplicados
        $exists = Visit::where('standId', $stand->id)
                       ->where('participantId', $participant->id)
                       ->exists();

        if ($exists) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true, 
                    'message' => 'Participante ya había sido registrado hoy.',
                    'participantId' => $participant->id,
                    'participantName' => $participant->name
                ]);
            }
            return redirect()->back()->with('success', 'Participante ya estaba registrado.');
        }

        try {
            DB::transaction(function () use ($stand, $participant) {
                Visit::create([
                    'standId' => $stand->id,
                    'participantId' => $participant->id,
                ]);
                $stand->increment('totalVisits');
            });

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true, 
                    'message' => 'Visita registrada correctamente.',
                    'participantId' => $participant->id,
                    'participantName' => $participant->name
                ]);
            }

            return redirect()->back()->with('success', 'Visita registrada correctamente.');
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Error al registrar visita.'], 500);
            }
            return redirect()->back()->with('error', 'Error al procesar la visita.');
        }
    }
}
