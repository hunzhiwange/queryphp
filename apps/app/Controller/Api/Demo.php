<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Service\Demo\Demo as AppDemoService;

/**
 * @codeCoverageIgnore
 */
class Demo 
{
    public function __construct(private AppDemoService $service)
    {
    }

    public function handle(): array
    {
        return $this->service->handle();
    }
}
