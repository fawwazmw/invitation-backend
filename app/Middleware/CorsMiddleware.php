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
        // Add detailed logging
        error_log('CORS Request Details:');
        error_log('Origin: ' . $request->header('Origin'));
        error_log('Method: ' . $request->method());

        $header = respond()->getHeader();

        // Define allowed domains
        $allowedOrigins = [
            'https://weddinginvitation.fwzdev.site',
            // Add other domains if needed
        ];

        $origin = $request->header('Origin');

        // Only allow specified origins
        if (in_array($origin, $allowedOrigins)) {
            $header->set('Access-Control-Allow-Origin', $origin);
        }

        // Set other CORS headers
        $header->set('Access-Control-Allow-Credentials', 'true');
        $header->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $header->set('Access-Control-Allow-Headers', 'X-Access-Key, Origin, X-Requested-With, Content-Type, Accept, Authorization');
        $header->set('Access-Control-Max-Age', '86400'); // Cache preflight for 24 hours

        // Handle preflight requests
        if ($request->method() === Request::OPTIONS) {
            error_log('Handling OPTIONS preflight request');
            return respond()
                ->setCode(Respond::HTTP_NO_CONTENT)
                ->send();
        }

        try {
            return $next($request);
        } catch (Exception $e) {
            error_log('CORS Error: ' . $e->getMessage());
            return respond()
                ->setCode(Respond::HTTP_INTERNAL_SERVER_ERROR)
                ->setBody(['error' => 'Internal Server Error'])
                ->send();
        }
    }
}
