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

namespace Admin\App\Controller\Permission;

use Admin\App\Controller\Support\Controller;
use Admin\App\Service\Permission\Store as Service;
use Leevel\Http\IRequest;

/**
 * 权限保存.
 *
 * @codeCoverageIgnore
 */
class Store
{
    use Controller;

    /**
     * 允许的输入字段.
     *
     * @var array
     */
    private array $allowedInput = [
        'name',
        'num',
        'status',
        'pid',
    ];

    /**
     * 响应方法.
     */
    public function handle(IRequest $request, Service $service): array
    {
        return $this->main($request, $service);
    }
}
