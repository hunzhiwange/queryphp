<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Permission;

use App\Domain\Entity\User\Permission;
use App\Domain\Service\Support\Store as CommonStore;

/**
 * 权限保存.
 */
class Store
{
    use CommonStore;

    protected string $entityClass = Permission::class;

    public function handle(StoreParams $params): array
    {
        $params->validate();
        $this->validateData($params);

        return $this->save($params)->toArray();
    }

    /**
     * 校验数据.
     */
    private function validateData(StoreParams $params): void
    {
        if ($params->pid > 0) {
            $this->validatePidData($params->pid);
        }
    }

    private function validatePidData(int $pid)
    {
        $this->find($pid);
    }
}
