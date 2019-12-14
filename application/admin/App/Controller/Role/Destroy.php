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

namespace Admin\App\Controller\Role;

use Admin\App\Controller\Support\Controller;
use Admin\App\Service\Role\Destroy as Service;
use Leevel\Http\IRequest;

/**
 * 角色删除.
 *
 * @codeCoverageIgnore
 */
class Destroy
{
    use Controller;

    public function handle(IRequest $request, Service $service): array
    {
        return $this->main($request, $service);
    }

    private function input(IRequest $request): array
    {
        return $this->restfulInput($request);
    }
}
