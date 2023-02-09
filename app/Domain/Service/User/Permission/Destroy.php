<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Permission;

use App\Domain\Entity\User\Permission;
use App\Domain\Service\Support\Destroy as CommonDestroy;
use App\Domain\Service\Support\DestroyParams;
use App\Exceptions\UserBusinessException;
use App\Exceptions\UserErrorCode;

/**
 * 权限删除.
 */
class Destroy
{
    use CommonDestroy;

    protected string $entityClass = Permission::class;

    /**
     * 校验.
     *
     * @throws \Exception
     */
    private function validate(DestroyParams $params): void
    {
        $this->checkChildren($params->id);
    }

    /**
     * 判断是否存在子项.
     *
     * @throws \App\Exceptions\UserBusinessException|\Exception
     */
    private function checkChildren(int $id): void
    {
        /** @var \App\Infra\Repository\User\Permission $permissionRepository */
        $permissionRepository = $this->w->repository(Permission::class);
        if ($permissionRepository->hasChildren($id)) {
            throw new UserBusinessException(UserErrorCode::PERMISSION_CONTAINS_SUB_KEY_AND_CANNOT_BE_DELETED);
        }
    }
}
