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
        // Always regenerate CSRF token for better security
        if ($request->isMethod('get')) {
            $request->session()->regenerateToken();
        }

        $response = $next($request);

        // Add CSRF token to response headers for AJAX requests
        if ($request->ajax() || $request->wantsJson()) {
            $response->headers->set('X-CSRF-TOKEN', csrf_token());
        }

        // Add CSRF token to meta tag for forms
        if ($request->isMethod('get')) {
            $response->headers->set('X-CSRF-TOKEN', csrf_token());
        }

        return $response;
    }
}