<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stand;
use Illuminate\Support\Str;

class StandController extends Controller
{
    public function index(Request $request)
    {
        $query = Stand::with('owner');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        if ($request->filled('status')) {
            $query->where('active', $request->status === 'active' ? 1 : 0);
        }

        $stands = $query->paginate(10)->appends($request->all());
        
        // Also pass users to the view so we can assign owners in the modal form
        $users = \App\Models\User::where('rol', 'user')->get();

        return view('admin.stands.index', compact('stands', 'users'));
    }

    public function store(Request $request)
    {
        abort_if(auth()->user()->rol !== 'admin', 403);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'ownerUserId' => 'nullable|exists:users,id',
            'active' => 'boolean',
        ]);

        $data['qrToken'] = Str::uuid()->toString();
        $data['active'] = $request->has('active');

        Stand::create($data);

        return redirect()->route('stands.index')->with('success', 'Stand creado exitosamente.');
    }

    public function update(Request $request, Stand $stand)
    {
        abort_if(auth()->user()->rol !== 'admin', 403);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'ownerUserId' => 'nullable|exists:users,id',
            'active' => 'boolean',
        ]);
        
        $data['active'] = $request->has('active');

        $stand->update($data);

        return redirect()->route('stands.index')->with('success', 'Stand actualizado exitosamente.');
    }

    public function destroy(Stand $stand)
    {
        abort_if(auth()->user()->rol !== 'admin', 403);

        $stand->delete();
        return redirect()->route('stands.index')->with('success', 'Stand eliminado.');
    }
}
