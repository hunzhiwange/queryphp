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

namespace Admin\App\Service\Role;

use Common\Domain\Service\User\Role\Destroy as Service;

/**
 * 角色删除状态.
 */
class Destroy
{
    private Service $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    public function handle(array $input): array
    {
        return $this->service->handle($input);
    }
}
