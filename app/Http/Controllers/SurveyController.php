<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Survey;
use App\Models\Stand;
use Illuminate\Support\Facades\DB;

class SurveyController extends Controller
{
    public function index()
    {
        $surveys = Survey::with('stand', 'participant')->latest()->paginate(15);
        $eventSurveys = \App\Models\EventSurvey::with('participant')->latest()->paginate(15);
        
        return view('admin.surveys.index', compact('surveys', 'eventSurveys'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'standId' => 'required|exists:stands,id',
            'participantId' => 'required|exists:participants,id',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $stand = Stand::findOrFail($request->standId);

        // Evitar múltiples encuestas del mismo participante en el mismo stand
        $existingSurvey = Survey::where('standId', $stand->id)
                                ->where('participantId', $request->participantId)
                                ->first();

        if ($existingSurvey) {
            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'message' => 'Este participante ya había valorado el stand.']);
            }
            return redirect()->back()->with('error', 'Este participante ya valoró el stand.');
        }

        DB::transaction(function () use ($request, $stand) {
            Survey::create([
                'standId' => $stand->id,
                'participantId' => $request->participantId,
                'rating' => $request->rating,
            ]);

            $totalSurveys = Survey::where('standId', $stand->id)->count();
            $avgRating = Survey::where('standId', $stand->id)->avg('rating');

            $stand->update([
                'totalSurveys' => $totalSurveys,
                'avgRating' => $avgRating,
            ]);
        });

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Encuesta registrada con éxito.']);
        }
        return redirect()->back()->with('success', 'Encuesta guardada exitosamente.');
    }
}
