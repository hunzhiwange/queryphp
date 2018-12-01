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

namespace Admin\App\Service\User;

use Common\Domain\Entity\User;
use Leevel\Database\Ddd\IUnitOfWork;
use Leevel\Kernel\HandleException;
use Leevel\Validate as Validates;
use Leevel\Validate\IValidator;

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

        $this->save($input)->toArray();

        return [];
    }

    /**
     * 保存.
     *
     * @param array $input
     *
     * @return \Common\Domain\Entity\User
     */
    protected function save(array $input): User
    {
        $this->w->persist($resource = $this->entity($input));

        $this->w->flush();

        return $resource;
    }

    /**
     * 验证参数.
     *
     * @param array $input
     *
     * @return \Common\Domain\Entity\User
     */
    protected function entity(array $input): User
    {
        $resource = $this->find((int) $input['id']);

        $resource->withProps($this->data($input));

        return $resource;
    }

    /**
     * 查找实体.
     *
     * @param int $id
     *
     * @return \Common\Domain\Entity\User
     */
    protected function find(int $id): User
    {
        return $this->w->repository(User::class)->findOrFail($id);
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
            'email'        => $input['email'] ?: '',
            'mobile'       => $input['mobile'] ?: '',
        ];
    }

    /**
     * 校验基本参数.
     */
    protected function validateArgs()
    {
        $validator = Validates::make(
            $this->input,
            [
                'email'       => 'email|'.IValidator::CONDITION_VALUE,
                'mobile'      => 'mobile|'.IValidator::CONDITION_VALUE,
            ],
            [
                'email'       => __('邮件'),
                'mobile'      => __('手机'),
            ]
        );

        if ($validator->fail()) {
            throw new HandleException(json_encode($validator->error()));
        }
    }
}
