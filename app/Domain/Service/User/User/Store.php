<?php

declare(strict_types=1);

namespace App\Domain\Service\User\User;

use App\Domain\Entity\User\User;
use App\Domain\Service\Support\Store as CommonStore;
use Leevel\Auth\Hash;
use Leevel\Database\Ddd\UnitOfWork;

/**
 * 用户保存.
 */
class Store
{
    use BaseStoreUpdate;
    use CommonStore;

    protected string $entityClass = User::class;

    public function __construct(
        private UnitOfWork $w,
        private Hash $hash,
    ) {
    }

    public function handle(StoreParams $params): array
    {
        $params->validate();

        return $this->prepareData($this->save($params));
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
    private function data(StoreParams $params): array
    {
        return [
            'name'       => $params->name,
            'num'        => $params->num,
            'status'     => $params->status,
            'password'   => $this->createPassword($params->password),
        ];
    }
}
