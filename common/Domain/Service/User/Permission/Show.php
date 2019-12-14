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

namespace Common\Domain\Service\User\Permission;

use Common\Domain\Entity\User\Permission;
use Leevel\Database\Ddd\IUnitOfWork;

/**
 * 权限查询.
 */
class Show
{
    private IUnitOfWork $w;

    /**
     * 构造函数.
     */
    public function __construct(IUnitOfWork $w)
    {
        $this->w = $w;
    }

    /**
     * 响应方法.
     */
    public function handle(array $input): array
    {
        $entity = $this->find($input['id']);
        $result = $entity->toArray();
        $result['resource'] = $entity->resource->toArray();

        return $result;
    }

    /**
     * 查找实体.
     */
    protected function find(int $id): Permission
    {
        return $this->w->repository(Permission::class)->findOrFail($id);
    }
}
