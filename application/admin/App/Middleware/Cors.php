<?php

declare(strict_types=1);

namespace Admin\App\Middleware;

use Closure;
use Leevel\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * CORS 中间件.
 */
class Cors
{
    /**
     * 响应.
     */
    public function terminate(Closure $next, Request $request, Response $response): void
    {
        $headers = [
            'Access-Control-Allow-Origin'      => '*',
            'Access-Control-Allow-Methods'     => 'GET, POST, PUT, DELETE, OPTIONS',
            'Access-Control-Allow-Headers'     => 'Origin, X-Requested-With, Content-Type, Accept, token',
            'Access-Control-Allow-Credentials' => 'true',
        ];
        $response->headers->add($headers);
        $next($request, $response);
    }
}
