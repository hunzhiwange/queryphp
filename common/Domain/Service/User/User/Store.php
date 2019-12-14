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
use Leevel\Auth\Hash;
use Leevel\Database\Ddd\IUnitOfWork;

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
    private $hash;

    private IUnitOfWork $w;

    public function __construct(IUnitOfWork $w, Hash $hash)
    {
        $this->w = $w;
        $this->hash = $hash;
    }

    public function handle(array $input): array
    {
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
    private function findRoles(int $userId): array
    {
        return [];
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
}
