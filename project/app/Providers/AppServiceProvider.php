<?php

namespace App\Providers;

use App\Interfaces\FileDataRepositoryInterface;
use App\Repositories\FileDataRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            FileDataRepositoryInterface::class,
            FileDataRepository::class
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
