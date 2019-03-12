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

namespace Admin\App\Service\User;

use Common\Infra\Repository\User\User\Permission as Repository;

/**
 * 用户权限数据服务.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.11.23
 *
 * @version 1.0
 */
class Permission
{
    /**
     * 用户权限数据服务.
     *
     * @var \Common\Infra\Repository\User\User\Permission
     */
    protected $repository;

    /**
     * 构造函数.
     *
     * @param \Common\Infra\Repository\User\User\Permission $repository
     */
    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * 响应方法.
     *
     * @param array $input
     *
     * @return array
     */
    public function handle(array $input): array
    {
        return $this->repository->handle($input);
    }
}
