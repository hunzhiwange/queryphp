<?php

declare(strict_types=1);

namespace App\Project\Service\ProjectTag;

use App\Infra\Service\Support\Update as CommonUpdate;
use App\Project\Entity\ProjectTag;

/**
 * 项目标签更新.
 */
class Update
{
    use CommonUpdate;

    private ?ProjectTag $entity = null;

    public function beforeHandle(UpdateParams $params): void
    {
        $this->entity = $this->find($params->id, $params);
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
