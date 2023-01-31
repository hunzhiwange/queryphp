<?php

declare(strict_types=1);

namespace App\Domain\Service\User\User;

use App\Domain\Entity\User\User;
use App\Domain\Service\Support\Update as CommonUpdate;
use Leevel\Auth\Hash;
use Leevel\Database\Ddd\UnitOfWork;

/**
 * 用户更新.
 */
class Update
{
    use BaseStoreUpdate;
    use CommonUpdate;

    protected string $entityClass = User::class;

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
     * 创建密码
     */
    private function createPassword(string $password): string
    {
        return $this->hash->password($password);
    }
}
