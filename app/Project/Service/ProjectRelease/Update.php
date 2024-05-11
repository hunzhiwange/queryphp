<?php

declare(strict_types=1);

namespace App\Project\Service\ProjectRelease;

use App\Infra\Service\Support\Update as CommonUpdate;
use App\Project\Entity\ProjectRelease;

/**
 * 项目版本更新.
 */
class Update
{
    use CommonUpdate;

    private ?ProjectRelease $entity = null;

    public function beforeHandle(UpdateParams $params): void
    {
        $this->entity = $this->find($params->id, $params);
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
        return $params::exceptInput(
            $params->except(['id'])
            ->withoutNull()
            ->toArray())
        ;
    }
}
