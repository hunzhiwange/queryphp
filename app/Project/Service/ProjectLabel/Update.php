<?php

declare(strict_types=1);

namespace App\Project\Service\ProjectLabel;

use App\Infra\Service\Support\Update as CommonUpdate;
use App\Project\Entity\ProjectLabel;

/**
 * 项目分类更新.
 */
class Update
{
    use CommonUpdate;

    private ?ProjectLabel $entity = null;

    public function beforeHandle(UpdateParams $params): void
    {
        $this->entity = $this->find($params->id, $params);
        $params->projectId = $this->entity->projectId;
    }

    /**
     * 验证参数.
     */
    private function entity(UpdateParams $params): ProjectLabel
    {
        return $this->entity->withProps($this->data($params));
    }
}
