<?php

declare(strict_types=1);

namespace Common\Domain\Service\User\Role;

use Common\Domain\Entity\User\Role;
use Leevel\Database\Ddd\UnitOfWork;

/**
 * 角色查询.
 */
class Show
{
    public function __construct(private UnitOfWork $w)
    {
    }

    public function handle(array $input): array
    {
        $entity = $this->find($input['id']);
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
