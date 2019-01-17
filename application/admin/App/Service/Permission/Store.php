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

namespace Admin\App\Service\Permission;

use Common\Domain\Entity\Permission;
use Leevel\Database\Ddd\IUnitOfWork;
use Leevel\Kernel\HandleException;
use Leevel\Validate\Facade\Validate;
use Leevel\Validate\UniqueRule;

/**
 * 权限保存.
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
     * 输入数据.
     *
     * @var array
     */
    protected $input;

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
        $this->input = $input;

        $this->validateArgs();

        return $this->save($input)->toArray();
    }

    /**
     * 保存.
     *
     * @param array $input
     *
     * @return \Common\Domain\Entity\Permission
     */
    protected function save(array $input): Permission
    {
        $this->w->persist($entity = $this->entity($input))->

        flush();

        $entity->refresh();

        return $entity;
    }

    /**
     * 创建实体.
     *
     * @param array $input
     *
     * @return \Common\Domain\Entity\Permission
     */
    protected function entity(array $input): Permission
    {
        return new Permission($this->data($input));
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

    /**
     * 校验基本参数.
     */
    protected function validateArgs()
    {
        $validator = Validate::make(
            $this->input,
            [
                'name'          => 'required|chinese_alpha_num|max_length:50',
                'identity'      => 'required|alpha_dash|'.UniqueRule::rule(Permission::class),
            ],
            [
                'name'          => __('名字'),
                'identity'      => __('标识符'),
            ]
        );

        if ($validator->fail()) {
            throw new HandleException(json_encode($validator->error()));
        }
    }
}
