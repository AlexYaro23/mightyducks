<?php

namespace App\Providers;

use App\Repositories\TrainingRepository;
use Illuminate\Support\ServiceProvider;
use App\Models\Team;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('frontend.main', function($view)
        {
            $view->with('teamData', Team::find(config('mls.team_id')));
            $view->with('trainingData', TrainingRepository::getActiveList(config('mls.team_id')));
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
