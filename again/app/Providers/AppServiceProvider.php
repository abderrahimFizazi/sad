<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Observers\NoteObserver;
use App\Models\note;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Note::observe(NoteObserver::class);

    }
}
