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

use Common\Infra\Repository\Base\GetOption as Repository;

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
     * @var \Common\Infra\Repository\Base\GetOption
     */
    protected $repository;

    /**
     * 构造函数.
     *
     * @param \Common\Infra\Repository\Base\GetOption $repository
     */
    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * 响应方法.
     *
     * @return array
     */
    public function handle(): array
    {
        return $this->repository->handle();
    }
}
