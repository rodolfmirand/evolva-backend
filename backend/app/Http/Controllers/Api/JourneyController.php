<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Journey;
use Illuminate\Support\Facades\Auth;

class JourneyController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $journeys = $user->journeys()->with('users', 'tasks')->get();
        return response()->json($journeys);
    }

    public function show($id)
    {
        $journey = Journey::with('users', 'tasks')->findOrFail($id);
        return response()->json($journey);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_private' => 'boolean'
        ]);

        $journey = Journey::create([
            'title' => $request->title,
            'description' => $request->description,
            'is_private' => $request->is_private ?? true
        ]);

        // Adicionar o usuário criador como mestre
        $journey->users()->attach(Auth::id(), ['is_master' => true]);

        return response()->json($journey, 201);
    }

    public function join(Request $request)
    {
        $request->validate([
            'join_code' => 'required|string|size:6',
        ]);

        $journey = Journey::where('join_code', strtoupper($request->join_code))->first();

        if (!$journey) {
            return response()->json(['message' => 'Jornada não encontrada'], 404);
        }

        $user = Auth::user();

        if ($journey->users()->where('user_id', $user->id)->exists()) {
            return response()->json(['message' => 'Você já está nessa jornada'], 409);
        }

        $journey->users()->attach($user->id, ['is_master' => false]);

        return response()->json($journey);
    }
}
