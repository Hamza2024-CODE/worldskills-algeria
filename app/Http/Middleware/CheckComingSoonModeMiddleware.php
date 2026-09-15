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
        // 1. Secret bypass parameter (?preview=1 or ?bypass=1) stored in session
        if ($request->has('preview') || $request->has('bypass')) {
            $val = (string) ($request->query('preview') ?? $request->query('bypass'));
            if (in_array(strtolower($val), ['1', 'true', 'yes', 'on', 'secret'], true)) {
                session(['bypass_coming_soon' => true]);
            } elseif (in_array(strtolower($val), ['0', 'false', 'no', 'off'], true)) {
                session()->forget('bypass_coming_soon');
            }
        }

        // 2. Allow if preview session active
        if (session('bypass_coming_soon')) {
            return $next($request);
        }

        // 3. In local environment or if BYPASS_COMING_SOON=true in .env, bypass automatically
        if (env('BYPASS_COMING_SOON') === true || (app()->environment('local') && env('BYPASS_COMING_SOON', true) !== false)) {
            return $next($request);
        }

        // 4. Allow authenticated users (Admins / Staff / Organizers)
        if (auth()->check()) {
            return $next($request);
        }

        $settings = app(SettingsEngine::class);
        $comingSoonEnabled = $settings->getBool('coming_soon_mode', false);

        if ($comingSoonEnabled) {
            // Allowed paths when Coming Soon mode is active
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
                // Strictly redirect public visitors to the coming-soon page
                return redirect()->route('coming-soon');
            }
        }

        return $next($request);
    }
}
