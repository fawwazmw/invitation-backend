<?php

namespace App\Middleware;

use Closure;
use Core\Http\Request;
use Core\Http\Respond;
use Core\Middleware\MiddlewareInterface;

final class CorsMiddleware implements MiddlewareInterface
{
    public function handle(Request $request, Closure $next)
    {
        // Add logging to verify middleware is running
        error_log('CORS Middleware is running');

        $header = respond()->getHeader();

        // Set allowed origins
        $header->set('Access-Control-Allow-Origin', 'https://weddinginvitation.fwzdev.site');
        $header->set('Access-Control-Allow-Credentials', 'true');
        $header->set('Access-Control-Allow-Methods', '*');
        $header->set('Access-Control-Allow-Headers', '*');

        // Handle preflight
        if ($request->method(Request::OPTIONS)) {
            error_log('Handling OPTIONS request');
            return respond()->setCode(Respond::HTTP_NO_CONTENT);
        }

        return $next($request);
    }
}
