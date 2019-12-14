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

namespace Admin\App\Controller\Resource;

use Admin\App\Controller\Support\Controller;
use Admin\App\Service\Resource\Status as Service;
use Leevel\Http\IRequest;

/**
 * 批量修改资源状态.
 *
 * @codeCoverageIgnore
 */
class Status
{
    use Controller;

    private array $allowedInput = [
        'ids',
        'status',
    ];

    public function handle(IRequest $request, Service $service): array
    {
        return $this->main($request, $service);
    }
}
