<?php

declare(strict_types=1);

namespace App\Infra\Bootstrap;

use Symfony\Component\HttpFoundation\Response;

class CorsHeaders
{
    public function handle(): void
    {
        register_shutdown_function(function (): void {
            // 检查头信息是否已发送，如果未发送则发送 CORS 头信息
            // 这里用于代码中使用 die() 或 exit() 时，未发送 CORS 头信息的情况
            if (!headers_sent()) {
                $response = response_add_cors_headers(new Response());
                $response->send();
            }
        });
    }
}
