<?php

namespace App\Providers;

use App\Interfaces\FileDataRepositoryInterface;
use App\Interfaces\FileHistoryRepositoryInterface;
use App\Repositories\FileDataRepository;
use App\Repositories\FileHistoryRepository;
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

        $this->app->bind(
            FileHistoryRepositoryInterface::class,
            FileHistoryRepository::class
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
