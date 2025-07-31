<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Repositories\Contracts\UserRepositoryInterface::class,
            \App\Repositories\EloquentUserRepository::class
        );

        $this->app->bind(
            \App\Repositories\Contracts\PurveyorRepositoryInterface::class,
            \App\Repositories\EloquentPurveyorRepository::class
        );

        $this->app->bind(
            \App\Repositories\Contracts\AssistanceRepositoryInterface::class,
            \App\Repositories\EloquentAssistanceRepository::class
        );

        $this->app->bind(
            \App\Repositories\Contracts\PurveyorAssistanceRepositoryInterface::class,
            \App\Repositories\EloquentPurveyorAssistanceRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
