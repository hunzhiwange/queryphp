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

namespace Admin\App\Service\Base;

use Common\Domain\Service\Base\GetOption as Service;

/**
 * 获取配置服务.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.11.23
 *
 * @version 1.0
 */
class GetOption
{
    /**
     * 获取配置服务.
     *
     * @var \Common\Domain\Service\Base\GetOption
     */
    protected $service;

    /**
     * 构造函数.
     *
     * @param \Common\Domain\Service\Base\GetOption $service
     */
    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    /**
     * 响应方法.
     *
     * @return array
     */
    public function handle(): array
    {
        return $this->service->handle();
    }
}
