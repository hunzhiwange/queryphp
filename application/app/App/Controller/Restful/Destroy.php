<?php

declare(strict_types=1);

namespace App\App\Controller\Restful;

use Leevel\Router\IRouter;

/**
 * @codeCoverageIgnore
 */
class Destroy
{
    public function handle(): string
    {
        return 'hello for restful '.IRouter::RESTFUL_DESTROY;
    }
}
