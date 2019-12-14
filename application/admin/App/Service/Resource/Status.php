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

namespace Admin\App\Service\Resource;

use Common\Domain\Service\User\Resource\Status as Service;

/**
 * 批量设置资源状态.
 */
class Status
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
