<?php

declare(strict_types=1);

namespace App\Infra\Middleware;

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
    public function handle(\Closure $next, Request $request): Response
    {
        $response = $next($request);

        return response_add_cors_headers($response);
    }
}
