<?php

namespace App\Services;

use App\Models\Journey;
use App\Models\User;
use \Illuminate\Database\Eloquent\Collection;

class JourneyService
{
    
    public function getAllJourneys(User $user): Collection
    {
        return $journeys = $user->journeys()->with('users', 'tasks')->get();
    }


    public function createJourney(array $data): Journey
    {
        $journey = Journey::create([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'is_private' => $data['is_private'] ?? true,
        ]);

        return $journey;
    }
}