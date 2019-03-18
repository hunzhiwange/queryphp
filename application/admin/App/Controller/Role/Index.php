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
use Admin\App\Service\Role\Index as service;
use Leevel\Http\IRequest;

/**
 * 角色列表.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.11.22
 *
 * @version 1.0
 */
class Index
{
    use Controller;

    /**
     * 允许的输入字段.
     *
     * @var array
     */
    private $allowedInput = [
        'key',
        'status',
        'page',
        'size',
    ];

    /**
     * 响应方法.
     *
     * @param \Leevel\Http\IRequest         $request
     * @param \Admin\App\Service\Role\Index $service
     *
     * @return array
     */
    public function handle(IRequest $request, Service $service): array
    {
        return $this->main($request, $service);
    }
}
