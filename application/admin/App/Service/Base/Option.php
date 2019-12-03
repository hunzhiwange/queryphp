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

use Common\Domain\Service\Base\Option as Service;

/**
 * 配置更新服务.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.10.23
 *
 * @version 1.0
 */
class Option
{
    /**
     * 配置更新服务.
     *
     * @var \Common\Domain\Service\Base\Option
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
