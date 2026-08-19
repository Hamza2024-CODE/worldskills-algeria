<?php

namespace App\Http\Middleware;

use App\Models\GlobalSetting;
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
        $comingSoonEnabled = GlobalSetting::getByKey('coming_soon_mode', '0') === '1';

        if ($comingSoonEnabled) {
            // Allow admin routes, auth routes, coming-soon route, assets, and language switcher
            $isAllowedPath = $request->is('hamza*')
                || $request->is('admin*')
                || $request->is('login*')
                || $request->is('logout*')
                || $request->is('coming-soon*')
                || $request->is('lang/*')
                || $request->is('vendor/*')
                || $request->is('api/*')
                || $request->is('sw.js')
                || $request->is('manifest.webmanifest');

            if (!$isAllowedPath) {
                // If user is an authenticated admin/super_admin, allow browsing
                $user = auth()->user();
                if ($user && ($user->hasRole('super_admin') || $user->hasRole('national_admin') || $user->is_admin)) {
                    return $next($request);
                }

                // Redirect public visitors to coming-soon page
                return redirect()->route('coming-soon');
            }
        }

        return $next($request);
    }
}
