<?php

declare(strict_types=1);

/*
 * This file is part of the forcodepoem package.
 *
 * The PHP Application Created By Code Poem. <Query Yet Simple>
 * (c) 2018-2099 http://forcodepoem.com All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Admin\App\Service\Resource;

use Common\Domain\Entity\Resource;
use Leevel\Database\Ddd\IUnitOfWork;

/**
 * 资源删除.
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
     * 事务工作单元.
     *
     * @var \Leevel\Database\Ddd\IUnitOfWork
     */
    protected $w;

    /**
     * 构造函数.
     *
     * @param \Leevel\Database\Ddd\IUnitOfWork $w
     */
    public function __construct(IUnitOfWork $w)
    {
        $this->w = $w;
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
        $this->remove($this->find($input['id']));

        return [];
    }

    /**
     * 删除实体.
     *
     * @param \Common\Domain\Entity\Resource $resource
     */
    protected function remove(Resource $resource)
    {
        $this->w->persist($resource)->
        remove($resource)->
        flush();
    }

    /**
     * 查找实体.
     *
     * @param int $intId
     *
     * @return \Common\Domain\Entity\Resource
     */
    protected function find(int $id): Resource
    {
        return $this->w->repository(Resource::class)->findOrFail($id);
    }
}
