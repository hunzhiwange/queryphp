<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectTag;

use App\Domain\Entity\Project\ProjectTag;
use App\Domain\Service\Support\Update as CommonUpdate;

/**
 * 项目标签更新.
 */
class Update
{
    use CommonUpdate;

    protected string $entityClass = ProjectTag::class;

    private ?ProjectTag $entity = null;

    public function beforeHandle(UpdateParams $params): void
    {
        $this->entity = $this->find($params->id);
        $params->projectId = $this->entity->projectId;
    }

    /**
     * 验证参数.
     */
    private function entity(UpdateParams $params): ProjectTag
    {
        return $this->entity->withProps($this->data($params));
    }
}
