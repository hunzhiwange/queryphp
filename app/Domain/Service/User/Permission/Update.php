<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Permission;

use App\Domain\Entity\User\Permission;
use App\Domain\Service\Support\Update as CommonUpdate;

/**
 * 权限更新.
 */
class Update
{
    use CommonUpdate;

    protected string $entityClass = Permission::class;

    private function validate(UpdateParams $params): void
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
