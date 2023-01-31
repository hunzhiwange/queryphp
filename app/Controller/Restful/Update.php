<?php

declare(strict_types=1);

namespace App\Controller\Restful;

use Leevel\Router\IRouter;

/**
 * @codeCoverageIgnore
 */
class Update
{
    public function handle(): string
    {
        return 'hello for restful '.IRouter::RESTFUL_UPDATE;
    }
}
