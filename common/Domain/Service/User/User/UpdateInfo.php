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

namespace Common\Domain\Service\User\User;

use Common\Domain\Entity\User\User;
use Common\Infra\Exception\BusinessException;
use Common\Infra\Support\WorkflowService;
use Leevel\Database\Ddd\IUnitOfWork;
use Leevel\Validate\IValidator;
use Leevel\Validate\Proxy\Validate as Validates;

/**
 * 用户修改资料.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.11.21
 *
 * @version 1.0
 */
class UpdateInfo
{
    use WorkflowService;

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
        $this->input = $input;
        $this->validateArgs();
        $this->save($input)->toArray();

        return [];
    }

    /**
     * 保存.
     */
    protected function save(array $input): User
    {
        $this->w->persist($entity = $this->entity($input));
        $this->w->flush();

        return $entity;
    }

    /**
     * 验证参数.
     */
    protected function entity(array $input): User
    {
        $entity = $this->find((int) $input['id']);
        $entity->withProps($this->data($input));

        return $entity;
    }

    /**
     * 查找实体.
     */
    protected function find(int $id): User
    {
        return $this->w
            ->repository(User::class)
            ->findOrFail($id);
    }

    /**
     * 组装实体数据.
     */
    protected function data(array $input): array
    {
        return [
            'email'        => $input['email'] ?: '',
            'mobile'       => $input['mobile'] ?: '',
        ];
    }

    /**
     * 校验基本参数.
     *
     * @throws \Common\Infra\Exception\BusinessException
     */
    protected function validateArgs()
    {
        $input = $this->filterEmptyStringInput($this->input);

        $validator = Validates::make(
            $input,
            [
                'email'       => 'email|'.IValidator::OPTIONAL,
                'mobile'      => 'mobile|'.IValidator::OPTIONAL,
            ],
            [
                'email'       => __('邮件'),
                'mobile'      => __('手机'),
            ]
        );

        if ($validator->fail()) {
            throw new BusinessException(json_encode($validator->error()));
        }
    }
}
