<?php

namespace App\Providers;

use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use App\Observers\TaskObserver;
use App\Observers\UserObserver;
use App\Observers\ProjectObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Project::observe(ProjectObserver::class);
        Task::observe(TaskObserver::class);
        User::observe(UserObserver::class);
    }
}
