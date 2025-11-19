<?php

namespace App\Observers;

use App\Models\Journey;

class JourneyObserver
{
    public function created(Journey $journey): void
    {
        $journey->store()->create();
    }
}
