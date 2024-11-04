<?php

namespace App\Providers;

use App\DDD\Auth\Domain\Repository\AdminRepositoryInterface;
use App\DDD\Auth\Infrastructure\AdminRepository;
use App\DDD\Blog\Domain\Repository\BlogRepositoryInterface;
use App\DDD\Blog\Infrastructure\BlogRepository;
use App\DDD\Comment\Domain\Repository\CommentRepositoryInterface;
use App\DDD\Comment\Infrastructure\CommentRepository;
use Illuminate\Support\ServiceProvider;
use App\DDD\Contact\Domain\Repositories\ContactRepositoryInterface;
use App\DDD\Contact\infrastructure\EloquentContactRepository as InfrastructureEloquentContactRepository;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ContactRepositoryInterface::class, InfrastructureEloquentContactRepository::class);
        $this->app->bind(CommentRepositoryInterface::class, CommentRepository::class);
        $this->app->bind(AdminRepositoryInterface::class, AdminRepository::class);
        $this->app->bind(BlogRepositoryInterface::class, BlogRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
