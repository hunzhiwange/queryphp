<?php

declare(strict_types=1);

namespace App\Middleware;

use Closure;
use Leevel\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * CORS 中间件.
 */
class Cors
{
    /**
     * 请求.
     */
    public function handle(Closure $next, Request $request): Response
    {
        $headers = [
            'Access-Control-Allow-Origin'      => '*',
            'Access-Control-Allow-Methods'     => 'GET, POST, PUT, DELETE, OPTIONS',
            'Access-Control-Allow-Headers'     => 'Origin, X-Requested-With, Content-Type, Accept, token',
            'Access-Control-Allow-Credentials' => 'true',
        ];

        $response = new Response();
        $response->headers->add($headers);
        $response->sendHeaders();
        
        return $next($request);
    }
}
