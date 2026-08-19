<?php

namespace App\Http\Middleware;

use App\Enums\RoleEnum;
use App\Services\SettingsEngine;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckComingSoonModeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $settings = app(SettingsEngine::class);
        $comingSoonEnabled = $settings->getBool('coming_soon_mode', false);

        if ($comingSoonEnabled) {
            // Check if current request path is an admin route, auth route, asset, or coming-soon page
            $isAdminRoute = $request->is('hamza*')
                || $request->is('admin*')
                || $request->is('login*')
                || $request->is('logout*')
                || $request->is('coming-soon*')
                || $request->is('lang/*')
                || $request->is('vendor/*')
                || $request->is('api/*')
                || $request->is('sw.js')
                || $request->is('manifest.webmanifest')
                || $request->is('livewire/*');

            if (!$isAdminRoute) {
                // Check if user is an authenticated admin
                $user = auth()->user();
                $isAdminUser = $user && (
                    $user->hasRole(RoleEnum::SUPER_ADMIN->value) ||
                    $user->hasRole(RoleEnum::NATIONAL_ADMIN->value) ||
                    $user->hasRole(RoleEnum::MEDIA_MANAGER->value) ||
                    !empty($user->is_admin)
                );

                if (!$isAdminUser) {
                    // Block public visitors entirely & redirect to Coming Soon landing page
                    return redirect()->route('coming-soon');
                }
            }
        }

        return $next($request);
    }
}
