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

use Common\Domain\Service\User\Resource\Destroy as Service;

/**
 * 资源删除状态.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.10.23
 *
 * @version 1.0
 */
class Destroy
{
    /**
     * 资源删除服务.
     *
     * @var \Common\Domain\Service\User\Resource\Destroy
     */
    protected $service;

    /**
     * 构造函数.
     */
    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    /**
     * 响应方法.
     */
    public function handle(array $input): array
    {
        return $this->service->handle($input);
    }
}
