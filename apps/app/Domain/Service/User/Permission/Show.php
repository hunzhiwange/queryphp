<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Permission;

use App\Domain\Entity\User\Permission;
use Leevel\Database\Ddd\UnitOfWork;

/**
 * 权限查询.
 */
class Show
{
    public function __construct(private UnitOfWork $w)
    {
    }

    public function handle(ShowParams $params): array
    {
        $entity = $this->find($params->id);
        $result = $entity->toArray();
        $result['resource'] = $entity->resource->toArray();

        return $result;
    }

    /**
     * 查找实体.
     */
    private function find(int $id): Permission
    {
        return $this->w->repository(Permission::class)->findOrFail($id);
    }
}
