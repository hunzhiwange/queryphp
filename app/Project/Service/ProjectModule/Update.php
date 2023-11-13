<?php

declare(strict_types=1);

namespace App\Project\Service\ProjectModule;

use App\Infra\Service\Support\Update as CommonUpdate;
use App\Project\Entity\ProjectModule;

/**
 * 项目模块更新.
 */
class Update
{
    use CommonUpdate;

    private ?ProjectModule $entity = null;

    public function beforeHandle(UpdateParams $params): void
    {
        $this->entity = $this->find($params->id, $params);
        $params->projectId = $this->entity->projectId;
    }

    /**
     * 更新实体.
     */
    private function entity(UpdateParams $params): ProjectModule
    {
        return $this->entity->withProps($this->data($params));
    }
}
