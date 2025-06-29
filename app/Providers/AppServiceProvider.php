<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;

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
        //Customized login throttling (rate limiting for login attempts)  for specific IP
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->email.$request->ip());
        });
        // Should return TRUE or FALSE - check if the user is an admin
        Gate::define('manage_users', function(User $user) {
            return $user->is_admin == 1;
        });
        //Snooping/session hijacking: Force HTTPS scheme for URLs
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
