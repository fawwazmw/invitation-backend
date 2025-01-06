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
        $header = respond()->getHeader();

        // Set allowed origins
        $header->set('Access-Control-Allow-Origin', 'https://weddinginvitation.fwzdev.site');
        $header->set('Access-Control-Allow-Credentials', 'true');
        $header->set('Access-Control-Expose-Headers', 'Authorization, Content-Type, Cache-Control, Content-Disposition');

        // Allow common HTTP methods
        $header->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');

        // Added x-access-key to allowed headers
        $header->set('Access-Control-Allow-Headers', 'Origin, Content-Type, Accept, Authorization, X-Requested-With, X-Access-Key');

        $header->set('Access-Control-Max-Age', '86400');

        $vary = $header->has('Vary') ? explode(', ', $header->get('Vary')) : [];
        $vary = array_unique([...$vary, 'Accept', 'Origin', 'User-Agent', 'Access-Control-Request-Method', 'Access-Control-Request-Headers']);
        $header->set('Vary', join(', ', $vary));

        if ($request->method(Request::OPTIONS)) {
            return respond()->setCode(Respond::HTTP_NO_CONTENT);
        }

        return $next($request);
    }
}
