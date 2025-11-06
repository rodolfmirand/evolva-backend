<?php

namespace App\Services;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;

class TaskService
{
    public function assignTaskToUser(int $taskId, int $userId)
    {
        $task = Task::findOrFail($taskId);
        $user = User::findOrFail($userId);

        // Verifica se o usuário participa da mesma Journey
        $isInJourney = $user->journeys()->where('journey_id', $task->journey_id)->exists();

        if (!$isInJourney) {
            throw new AuthorizationException('Usuário não pertence a esta jornada.');
        }

        $user->tasks()->syncWithoutDetaching([$taskId => ['assigned_at' => now()]]);
    }
}
