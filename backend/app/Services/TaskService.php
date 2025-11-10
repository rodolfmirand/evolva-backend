<?php

namespace App\Services;

use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Access\AuthorizationException;

class TaskService
{
    public function assignTaskToUser(int $taskId, int $userId)
    {
        $task = Task::findOrFail($taskId);
        $user = User::findOrFail($userId);

        // Verifica se o usuário participa da mesma Journey
        if (!$user->journeys()->where('journey_id', $task->journey_id)->exists()) {
            throw new AuthorizationException('Usuário não pertence a esta jornada.');
        }

        $user->tasks()->syncWithoutDetaching([
            $taskId => ['assigned_at' => now()]
        ]);
    }

    public function createTask(array $data, User $user): Task
    {
        return DB::transaction(function () use ($data, $user) {

            // Criar a tarefa diretamente via relacionamento da Journey (mais limpo)
            $journey = $user->journeys()
                ->where('journey_id', $data['journey_id'])
                ->wherePivot('is_master', true)
                ->firstOrFail();

            return $journey->tasks()->create([
                'title'          => $data['title'],
                'description'    => $data['description'] ?? null,
                'type'           => $data['type'] ?? 'normal',
                'xp_reward'      => $data['xp_reward'],
                'coin_reward'    => $data['coin_reward'],
                'deadline'       => $data['deadline'] ?? null,
                'is_completed'   => false,
                'requires_proof' => $data['requires_proof'] ?? false,
                'proof_url'      => $data['proof_url'] ?? null,
                'created_by'     => $user->id
            ]);
        });
    }
}
