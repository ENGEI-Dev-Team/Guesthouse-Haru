<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\DDD\Contact\Domain\Repositories\ContactRepositoryInterface;
use App\DDD\Contact\infrastructure\EloquentContactRepository as InfrastructureEloquentContactRepository;
use App\DDD\Contact\Infrastructure\Repositories\EloquentContactRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ContactRepositoryInterface::class, InfrastructureEloquentContactRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
