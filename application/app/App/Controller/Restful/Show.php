<?php

declare(strict_types=1);

namespace App\App\Controller\Restful;

use Leevel\Http\Request;
use Leevel\Router\IRouter;

/**
 * @codeCoverageIgnore
 */
class Show
{
    public function handle(Request $request): string
    {
        return 'hello for restful '.IRouter::RESTFUL_SHOW.
            ' and id is '.$request->attributes->get(IRouter::RESTFUL_ID);
    }
}
