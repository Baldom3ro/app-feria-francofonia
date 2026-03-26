<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Participant;
use App\Mail\ParticipantAccessMail;
use Illuminate\Support\Facades\Mail;

class ParticipantController extends Controller
{
    public function index(Request $request)
    {
        $query = Participant::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        $participants = $query->latest()->paginate(15)->appends($request->all());

        return view('admin.participants.index', compact('participants'));
    }

    public function create()
    {
        return view('participants.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'paternalLastName' => 'required|string|max:255',
            'maternalLastName' => 'required|string|max:255',
            'city' => 'required|string|max:150',
            'municipality' => 'required|string|max:150',
            'sex' => 'required|string|max:50',
            'email' => 'required|email|unique:participants,email',
        ]);

        $participant = Participant::create($data);

        // Envío de correo automático con manejo de excepciones por si el mailer no está configurado (Local)
        try {
            Mail::to($participant->email)->send(new ParticipantAccessMail($participant));
            $msg = 'Participante registrado exitosamente. El código QR ha sido enviado a su correo.';
        } catch (\Exception $e) {
            $msg = 'Participante registrado localmente, pero '. $e->getMessage() .'. Revisa tu conexión/configuración SMTP en el archivo .env.';
        }

        return redirect()->route('participants.index')->with('success', $msg);
    }
    
    // Si se necesitara editar más adelante, se pueden agregar métodos edit/update aquí.
    
    public function destroy(Request $request, Participant $participant)
    {
        // Solo administradores pueden eliminar asistentes registrados.
        /** @var \App\Models\User $user */
        $user = $request->user();
        abort_if($user->rol !== 'admin', 403);

        $participant->delete();
        return redirect()->route('participants.index')->with('success', 'Participante eliminado.');
    }
}
