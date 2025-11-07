<?php

namespace App\Services;

use App\Models\Journey;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

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

    public function getUsersJourneys(int $journeyId): Collection
    {
        $journey = Journey::with('users')->find($journeyId);

        if (!$journey) {
            abort(404, 'Jornada não encontrada.');
        }

        return $journey->users->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'is_master' => (bool) $user->pivot->is_master,
            ];
        });
    }


    /**
     * Atualiza uma jornada se o usuário for mestre.
     * 
     * @param int $id  ID da jornada
     * @param array $data  Dados para atualização validados no request
     * @param User $user  Usuário autenticado que fez a requisição
     * @return Journey
     * 
     */
    public function updateJourney(int $id, array $data, User $user): Journey
    {
        
        $journey = Journey::with('users','tasks')->find($id);

        if (!$journey) {
            abort(404, 'Jornada não encontrada.'); //TODO: alterar para throw, adicionei dessa forma para ser mais rápido
        }

        $pivot = $journey->users()->where('user_id', $user->id)->first();

        if (!$pivot) {
            abort(403, 'Você não participa dessa jornada.');
        }

        if (!$pivot->pivot->is_master) {
            abort(403, 'Apenas mestres podem atualizar a jornada.');
        }

        $fields = [];
        if (isset('title', $data)) {
            $fields['title'] = $data['title'];
        }

        if (isset('description', $data)) {
            $fields['description'] = $data['description'];
        }

        if (isset('is_private', $data)) {
            $fields['is_private'] = $data['is_private'];
        }


        if (!empty($fields)) {
            //TODO: revisar o uso do transaction aqui
            DB::transaction(function () use ($journey, $fields) {
                $journey->fill($fields);
                $journey->save();
            });
        }

        return $journey->fresh(['users','tasks']);
    }

}
