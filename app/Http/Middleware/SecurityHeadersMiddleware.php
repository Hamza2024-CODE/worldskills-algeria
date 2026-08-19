<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeadersMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        /** @var Response $response */
        $response = $next($request);

        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'camera=(self), microphone=(), geolocation=(self)');
        $response->headers->set(
            'Content-Security-Policy',
            "default-src 'self' http: https: data: 'unsafe-inline' 'unsafe-eval'; base-uri 'self'; object-src 'self' data: blob: http: https:; frame-ancestors 'self'; form-action 'self' http: https:; img-src 'self' data: http: https: blob:; font-src 'self' data: http: https:; connect-src 'self' http: https: wss: ws:; script-src 'self' 'unsafe-inline' 'unsafe-eval' http: https:; style-src 'self' 'unsafe-inline' http: https:; upgrade-insecure-requests;"
        );

        return $response;
    }
}
