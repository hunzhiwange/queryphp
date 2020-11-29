<?php

declare(strict_types=1);

/*
 * This file is part of the your app package.
 *
 * The PHP Application For Code Poem For You.
 * (c) 2018-2099 http://yourdomian.com All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
