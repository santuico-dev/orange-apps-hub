<?php

namespace App\Providers;

use App\Repositories\Interface\PostInteractionInterface;
use App\Repositories\Interface\PostInterface;
use App\Repositories\Interface\UserInterface;
use App\Repositories\PostInteractionRepository;
use App\Repositories\PostRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(PostInterface::class, PostRepository::class);
        $this->app->bind(PostInteractionInterface::class, PostInteractionRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
