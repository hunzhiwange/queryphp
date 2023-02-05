<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectLabel;

use App\Domain\Entity\Project\ProjectLabel;
use App\Domain\Service\Support\Update as CommonUpdate;

/**
 * 项目分类更新.
 */
class Update
{
    use CommonUpdate;

    protected string $entityClass = ProjectLabel::class;

    private ?ProjectLabel $entity = null;

    public function beforeHandle(UpdateParams $params): void
    {
        $this->entity = $this->find($params->id);
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
