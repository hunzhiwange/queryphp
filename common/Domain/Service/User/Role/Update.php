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

namespace Common\Domain\Service\User\Role;

use Common\Domain\Entity\User\Role;
use Common\Infra\Support\WorkflowService;
use Leevel\Database\Ddd\IUnitOfWork;
use Leevel\Validate\UniqueRule;

/**
 * 角色更新.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.10.23
 *
 * @version 1.0
 */
class Update
{
    use WorkflowService;

    /**
     * 事务工作单元.
     *
     * @var \Leevel\Database\Ddd\IUnitOfWork
     */
    protected $w;

    /**
     * 工作流.
     *
     * @var array
     */
    private $workflow = [
        'allowedInput',
        'filterInput',
        'validateInput',
    ];

    /**
     * 允许的输入字段.
     *
     * @var array
     */
    private $allowedInput = [
        'id',
        'name',
        'num',
        'status',
    ];

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
        return $this->workflow($input);
    }

    /**
     * 过滤输入数据.
     *
     * @param array $input
     *
     * @return array
     */
    private function main(array &$input): array
    {
        return $this->save($input)->toArray();
    }

    /**
     * 验证参数.
     *
     * @param array $input
     *
     * @return \Common\Domain\Entity\User\Role
     */
    private function entity(array $input): Role
    {
        $entity = $this->find($input['id']);
        $entity->withProps($this->data($input));

        return $entity;
    }

    /**
     * 查找实体.
     *
     * @param int $id
     *
     * @return \Common\Domain\Entity\User\Role
     */
    private function find(int $id): Role
    {
        return $this->w
            ->repository(Role::class)
            ->findOrFail($id);
    }

    /**
     * 组装实体数据.
     *
     * @param array $input
     *
     * @return array
     */
    private function data(array $input): array
    {
        return [
            'name'       => $input['name'],
            'num'        => $input['num'],
            'status'     => $input['status'],
        ];
    }

    /**
     * 保存.
     *
     * @param array $input
     *
     * @return \Common\Domain\Entity\User\Role
     */
    private function save(array $input): Role
    {
        $this->w
            ->persist($entity = $this->entity($input))
            ->flush();
        $entity->refresh();

        return $entity;
    }

    /**
     * 过滤数据规则.
     *
     * @param array $input
     */
    private function filterInputRules(): array
    {
        return [
            'id'     => ['intval'],
            'status' => ['intval'],
        ];
    }

    /**
     * 校验数据规则.
     *
     * @param array $input
     *
     * @return array
     */
    private function validateInputRules(array $input): array
    {
        $rules = [
            'id' => [
                'required',
            ],
            'name' => [
                'required',
                'chinese_alpha_num',
                'max_length:50',
            ],
            'num' => [
                'required',
                'alpha_dash',
                UniqueRule::rule(Role::class, null, $input['id']),
            ],
        ];

        $names = [
            'id'            => 'ID',
            'name'          => __('名字'),
            'num'           => __('编号'),
        ];

        return [$rules, $names];
    }
}
