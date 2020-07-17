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
use Common\Domain\Entity\User\UserRole;
use Common\Infra\Exception\BusinessException;
use Leevel\Auth\Hash;
use Leevel\Collection\Collection;
use Leevel\Database\Ddd\UnitOfWork;
use Leevel\Validate\Proxy\Validate;
use Leevel\Validate\UniqueRule;

/**
 * 用户保存.
 */
class Store
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
        $this->input = $input;
        $this->validateArgs();

        return $this->prepareData($this->save($input));
    }

    /**
     * 保存.
     */
    private function save(array $input): User
    {
        $this->w->persist($entity = $this->entity($input));
        $this->w->on($entity, function (User $user) use ($input) {
            $this->setUserRole((int) $user->id, $input['userRole'] ?? []);
        });
        $this->w->flush();
        $entity->refresh();

        return $entity;
    }

    /**
     * 查找存在角色.
     */
    private function findRoles(): Collection
    {
        return UserRole::make()->collection();
    }

    /**
     * 创建实体.
     */
    private function entity(array $input): User
    {
        return new User($this->data($input));
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
        return [
            'name'       => trim($input['name']),
            'num'        => trim($input['num']),
            'status'     => $input['status'],
            'password'   => $this->createPassword(trim($input['password'])),
        ];
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
                'name'     => 'required|chinese_alpha_num|max_length:64',
                'num'      => 'required|alpha_dash|'.UniqueRule::rule(User::class, null, null, null, 'delete_at', 0),
                'password' => 'required|min_length:6,max_length:30',
            ],
            [
                'name'     => __('名字'),
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
