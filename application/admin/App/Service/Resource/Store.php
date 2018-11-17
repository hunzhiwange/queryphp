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
 * 资源保存.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.12.19
 *
 * @version 1.0
 */
class Store
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
        return $this->save($input)->toArray();
    }

    /**
     * 保存.
     *
     * @param array $input
     *
     * @return \Common\Domain\Entity\Resource
     */
    protected function save(array $input): Resource
    {
        $this->w->persist($resource = $this->entity($input))->

        flush();

        return $resource;
    }

    /**
     * 创建实体.
     *
     * @param array $input
     *
     * @return \Common\Domain\Entity\Resource
     */
    protected function entity(array $input): Resource
    {
        return new Resource($this->data($input));
    }

    /**
     * 组装实体数据.
     *
     * @param array $input
     *
     * @return array
     */
    protected function data(array $input): array
    {
        return [
            'name'       => trim($input['name']),
            'identity'   => trim($input['identity']),
            'status'     => $input['status'],
        ];
    }
}
