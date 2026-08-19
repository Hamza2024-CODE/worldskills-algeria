<?php

namespace App\Http\Middleware;

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
            // Allowed paths when Coming Soon mode is active (Admin backend, login, assets, coming-soon route)
            $isAllowedPath = $request->is('hamza*')
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

            if (!$isAllowedPath) {
                // Strictly redirect ALL public visitors to the coming-soon page
                return redirect()->route('coming-soon');
            }
        }

        return $next($request);
    }
}
