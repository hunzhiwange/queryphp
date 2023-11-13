<?php

declare(strict_types=1);

namespace App\Controller\Api;

use Leevel\Router\Route;

/**
 * @codeCoverageIgnore
 */
class Web
{
    #[Route(
        path: '/web/v1/demo/{name:[A-Za-z]+}/',
    )]
    public function demo1(string $name): string
    {
        return sprintf('web demo, your name is %s', $name);
    }

    #[Route(
        path: '/web/v2/demo/',
    )]
    public function demo2(): string
    {
        return 'web demo2';
    }
}
