<?php

namespace App\Services;

use App\Models\Journey;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class JourneyService
{
    public function getAllJourneys(User $user): Collection
    {
        return $user->journeys()->with('users', 'tasks')->get();
    }

    public function getJourneyById(int $id): Journey
    {
        return Journey::with('users', 'tasks')->findOrFail($id);
    }

    public function createJourney(array $data, User $user): Journey
    {
        $journey = Journey::create([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'is_private' => $data['is_private'] ?? true,
        ]);

        // Adiciona o criador como mestre
        $journey->users()->attach($user->id, ['is_master' => true]);

        return $journey;
    }

    public function joinJourney(string $joinCode, User $user): Journey
    {
        $journey = Journey::where('join_code', strtoupper($joinCode))->first();

        if (!$journey) {
            abort(404, 'Jornada não encontrada.');
        }

        // Se já participa, retorna erro 409
        if ($journey->users()->where('user_id', $user->id)->exists()) {
            abort(409, 'Você já está nessa jornada.');
        }

        $journey->users()->attach($user->id, ['is_master' => false]);

        return $journey;
    }
}
