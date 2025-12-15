<?php

namespace App\Providers;

use App\Models\Journey;
use App\Observers\JourneyObserver;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Journey::observe(JourneyObserver::class);
    }
}
