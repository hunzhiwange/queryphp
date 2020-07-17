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
use Common\Domain\Entity\User\UserRole as EntityUserRole;
use Common\Infra\Exception\BusinessException;
use Leevel\Auth\Hash;
use Leevel\Collection\Collection;
use Leevel\Database\Ddd\UnitOfWork;
use Leevel\Validate\IValidator;
use Leevel\Validate\Proxy\Validate;
use Leevel\Validate\UniqueRule;

/**
 * 用户更新.
 */
class Update
{
    use BaseStoreUpdate;

    /**
     * Hash 组件.
     *
     * @var \Leevel\Auth\Hash
     */
    private Hash $hash;

    private UnitOfWork $w;

    private array $input;

    public function __construct(UnitOfWork $w, Hash $hash)
    {
        $this->w = $w;
        $this->hash = $hash;
    }

    public function handle(array $input): array
    {
        if (empty($input['password'])) {
            unset($input['password']);
        }
        $this->input = $input;
        $this->validateArgs();

        if (!isset($input['userRole'])) {
            $input['userRole'] = [];
        }

        return $this->prepareData($this->save($input));
    }

    /**
     * 保存.
     */
    private function save(array $input): User
    {
        $this->w->persist($entity = $this->entity($input));
        $this->setUserRole((int) $input['id'], $input['userRole']);
        $this->w->flush();
        $entity->refresh();

        return $entity;
    }

    /**
     * 查找存在角色.
     */
    private function findRoles(int $userId): Collection
    {
        return $this->w
            ->repository(EntityUserRole::class)
            ->findAll(function ($select) use ($userId) {
                $select->where('user_id', $userId);
            });
    }

    /**
     * 验证参数.
     */
    private function entity(array $input): User
    {
        $entity = $this->find((int) $input['id']);
        $entity->withProps($this->data($input));

        return $entity;
    }

    /**
     * 查找实体.
     */
    private function find(int $id): User
    {
        return $this->w
            ->repository(User::class)
            ->findOrFail($id);
    }

    /**
     * 创建密码
     */
    private function createPassword(string $password): string
    {
        return $this->hash->password($password);
    }

    /**
     * 组装实体数据.
     */
    private function data(array $input): array
    {
        $data = [
            'num'    => trim($input['num']),
            'status' => $input['status'],
        ];

        if (isset($input['password']) && $password = trim($input['password'])) {
            $data['password'] = $this->createPassword($password);
        }

        return $data;
    }

    /**
     * 校验基本参数.
     *
     * @throws \Common\Infra\Exception\BusinessException
     */
    private function validateArgs(): void
    {
        $validator = Validate::make(
            $this->input,
            [
                'num'      => 'required|alpha_dash|'.UniqueRule::rule(User::class, null, (int) $this->input['id'], null, 'delete_at', 0),
                'password' => 'required|min_length:6,max_length:30'.'|'.IValidator::OPTIONAL,
            ],
            [
                'num'      => __('编号'),
                'password' => __('密码'),
            ]
        );

        if ($validator->fail()) {
            $e = json_encode($validator->error(), JSON_UNESCAPED_UNICODE);

            throw new BusinessException($e);
        }
    }
}
