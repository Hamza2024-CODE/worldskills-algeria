<?php

namespace App\Providers;

use App\Models\Country;
use App\Models\CountryDelegation;
use App\Models\Registration;
use App\Policies\CountryPolicy;
use App\Policies\DelegationPolicy;
use App\Policies\ParticipantPolicy;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        try {
            if (request()->header('X-Forwarded-Proto') === 'https' || request()->secure() || env('APP_ENV') !== 'local') {
                \Illuminate\Support\Facades\URL::forceScheme('https');
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        Gate::policy(Country::class, CountryPolicy::class);
        Gate::policy(CountryDelegation::class, DelegationPolicy::class);
        Gate::policy(Registration::class, ParticipantPolicy::class);

        // Named Rate Limiters (Generous for live production user experience)
        RateLimiter::for('verify', function (Request $request) {
            return Limit::perMinute(120)->by($request->ip());
        });

        RateLimiter::for('certificate', function (Request $request) {
            return Limit::perMinute(120)->by($request->ip());
        });

        RateLimiter::for('registration', function (Request $request) {
            return Limit::perMinute(120)->by($request->ip());
        });

        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(120)->by($request->ip());
        });
    }
}
