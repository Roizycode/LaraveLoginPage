<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RefreshCsrfToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Ensure session is started
        if (!$request->hasSession()) {
            $request->setLaravelSession(
                app('session.store')
            );
        }

        $response = $next($request);

        // Only regenerate CSRF token for successful POST requests (after form submission)
        if ($request->isMethod('post') && $response->getStatusCode() === 200) {
            $request->session()->regenerateToken();
        }

        // Add CSRF token to response headers for all requests
        $response->headers->set('X-CSRF-TOKEN', csrf_token());

        return $response;
    }
}