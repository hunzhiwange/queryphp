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

namespace Admin\App\Service\Login;

use Common\Domain\Service\Login\Code as Service;

/**
 * 验证生成服务.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.10.23
 *
 * @version 1.0
 */
class Code
{
    /**
     * 验证生成服务.
     *
     * @var \Common\Domain\Service\Login\Code
     */
    protected $service;

    /**
     * 构造函数.
     *
     * @param \Common\Domain\Service\Login\Code $service
     */
    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    /**
     * 响应方法.
     *
     * @param array $input
     *
     * @return string
     */
    public function handle(array $input): string
    {
        return $this->service->handle($input);
    }
}
