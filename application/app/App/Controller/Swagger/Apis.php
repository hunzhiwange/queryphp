<?php

declare(strict_types=1);

namespace App\App\Controller\Swagger;

/**
 * 文档汇总.
 * @codeCoverageIgnore
 */
class Apis
{
    /**
     * 响应.
     */
    public function handle(): array
    {
        return [
            [
                'name' => 'Web Api',
                'url'  => '/swagger/web',
            ],
            [
                'name' => 'QueryPHP API',
                'url'  => '/swagger',
            ],
        ];
    }
}
