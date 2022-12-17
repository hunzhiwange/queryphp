<?php

declare(strict_types=1);

namespace App\Domain\Service\User\User;

use App\Domain\Entity\User\User;
use Leevel\Auth\Hash;
use Leevel\Database\Ddd\UnitOfWork;

/**
 * 用户更新.
 */
class Update
{
    use BaseStoreUpdate;

    public function __construct(
        private UnitOfWork $w,
        private Hash $hash
    ) {
    }

    public function handle(UpdateParams $params): array
    {
        $params->validate();

        return $this->prepareData($this->save($params));
    }

    /**
     * 保存.
     */
    private function save(UpdateParams $params): User
    {
        $this->w->persist($entity = $this->entity($params));
        $this->w->flush();
        $entity->refresh();

        return $entity;
    }

    private function entity(UpdateParams $params): User
    {
        $entity = $this->find($params->id);
        foreach ($params->except(['id'])->toArray() as $field => $value) {
            if (null === $value) {
                continue;
            }

            if ('password' === $field) {
                $entity->password = $this->createPassword($value);
            } else {
                $entity->{$field} = $value;
            }
        }

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
}
