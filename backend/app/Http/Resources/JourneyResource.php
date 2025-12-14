<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JourneyResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'description' => $this->description,
            'join_code'   => $this->join_code,
            'is_private'  => $this->is_private,
            'image_url'   => $this->image_url,

            'members' => $this->whenLoaded('users', function () {
                return $this->users->map(function ($user) {
                    return [
                        'id'        => $user->id,
                        'name'      => $user->name,
                        'avatar'    => $user->avatar_url,
                        'is_master' => (bool) $user->pivot->is_master,
                    ];
                });
            }),

            'tasks' => $this->whenLoaded('tasks', function () {
                return $this->tasks->map(function ($task) {
                    return [
                        'id'          => $task->id,
                        'title'       => $task->title,
                        'description' => $task->description,
                        'xp'          => $task->xp_reward,
                        'coins'       => $task->coin_reward,
                    ];
                });
            }),

            'created_at' => $this->created_at,
        ];
    }
}
