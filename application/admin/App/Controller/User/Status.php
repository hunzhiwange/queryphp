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

namespace Admin\App\Controller\User;

use Admin\App\Controller\Support\Controller;
use Admin\App\Service\User\Status as Service;
use Leevel\Http\IRequest;

/**
 * 批量修改用户状态.
 *
 * @codeCoverageIgnore
 */
class Status
{
    use Controller;

    /**
     * 允许的输入字段.
     *
     * @var array
     */
    private array $allowedInput = [
        'ids',
        'status',
    ];

    /**
     * 响应方法.
     */
    public function handle(IRequest $request, Service $service): array
    {
        return $this->main($request, $service);
    }
}
