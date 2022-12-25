<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectModule;

use App\Domain\Entity\Project\ProjectModule;
use App\Domain\Service\Support\Update as CommonUpdate;

/**
 * 项目模块更新.
 */
class Update
{
    private ?ProjectModule $entity = null;

    use CommonUpdate;

    protected string $entityClass = ProjectModule::class;

    public function beforeHandle(UpdateParams $params): void
    {
        $this->entity = $this->find($params->id);
        $params->projectId = $this->entity->projectId;
    }

    /**
     * 验证参数.
     */
    private function entity(UpdateParams $params): ProjectModule
    {
        return $this->entity->withProps($this->data($params));
    }
}
