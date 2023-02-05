<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectRelease;

use App\Domain\Entity\Project\ProjectRelease;
use App\Domain\Service\Support\Update as CommonUpdate;

/**
 * 项目版本更新.
 */
class Update
{
    use CommonUpdate;

    protected string $entityClass = ProjectRelease::class;
    private ?ProjectRelease $entity = null;

    public function beforeHandle(UpdateParams $params): void
    {
        $this->entity = $this->find($params->id);
        $params->projectId = $this->entity->projectId;
    }

    /**
     * 更新实体.
     */
    private function entity(UpdateParams $params): ProjectRelease
    {
        return $this->entity->withProps($this->data($params));
    }

    /**
     * 组装实体数据.
     */
    private function data(UpdateParams $params): array
    {
        return $params
            ->except(['id'])
            ->withoutNull()
            ->toArray()
        ;
    }
}
