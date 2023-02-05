<?php

declare(strict_types=1);

namespace App\Controller\Swagger;

/**
 * 文档汇总.
 *
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
                'name' => 'Web',
                'url' => '/swagger/web',
            ],
            [
                'name' => 'API',
                'url' => '/swagger',
            ],
        ];
    }
}
