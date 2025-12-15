<?php

namespace App\Observers;

use App\Models\Journey;

class JourneyObserver
{
    public function created(Journey $journey): void
    {
        $journey->store()->create([
            'name' => 'Loja ' . $journey->id, // Remover  . $journey->id  se não quiser o ID no nome padrão
            'description' => null,
            'image_url' => null,
        ]);
    }
}
