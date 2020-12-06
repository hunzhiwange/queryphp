<?php

declare(strict_types=1);

namespace Common\Domain\Service\User\Permission;

use Common\Domain\Entity\User\Permission;
use Common\Domain\Service\Support\Destroy as CommonDestroy;
use Common\Infra\Exception\BusinessException;

/**
 * 权限删除.
 */
class Destroy
{
    use CommonDestroy;

    /**
     * 返回实体.
     */
    private function entity(): string
    {
        return Permission::class;
    }

    /**
     * 校验.
     */
    private function validate(array $input): void
    {
        $this->checkChildren((int) $input['id']);
    }

    /**
     * 判断是否存在子项.
     *
     * @throws \Common\Infra\Exception\BusinessException
     */
    private function checkChildren(int $id): void
    {
        /** @var \Common\Infra\Repository\User\Permission $permissionRepository */
        $permissionRepository = $this->w->repository(Permission::class);
        if ($permissionRepository->hasChildren($id)) {
            $e = __('权限包含子项，请先删除子项.');

            throw new BusinessException($e);
        }
    }
}
