<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Role;

use App\Domain\Entity\User\Role;
use Leevel\Database\Ddd\UnitOfWork;

/**
 * 角色查询.
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
        $result['permission'] = $entity->permission->toArray();

        return $result;
    }

    /**
     * 查找实体.
     */
    private function find(int $id): Role
    {
        return $this->w->repository(Role::class)->findOrFail($id);
    }
}
