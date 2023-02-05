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

    private function validate(StoreParams $params): void
    {
        if ($params->pid > 0) {
            $this->validatePidData($params->pid);
        }
    }

    private function validatePidData(int $pid): void
    {
        $this->find($pid);
    }
}
