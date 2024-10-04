<?php

namespace App\Providers;

use App\Interfaces\Repositories\{IFriendshipRepository, IUserRepository};
use App\Interfaces\Services\{IAuthService, IFriendshipService, IUserService};
use App\Repositories\{FriendshipRepository, UserRepository};
use App\Services\{AuthService, FriendshipService, UserService};
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IAuthService::class, AuthService::class);
        $this->app->bind(IUserRepository::class, UserRepository::class);
        $this->app->bind(IUserService::class, UserService::class);
        $this->app->bind(IFriendshipRepository::class, FriendshipRepository::class);
        $this->app->bind(IFriendshipService::class, FriendshipService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
