<?php

declare(strict_types=1);

namespace App\Project\Service\ProjectRelease;

use App\Project\Entity\ProjectRelease;
use Leevel\Database\Ddd\UnitOfWork;

/**
 * 项目版本查询.
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
        $result['project'] = $entity->project->toArray();

        return $result;
    }

    /**
     * 查找实体.
     */
    private function find(int $id): ProjectRelease
    {
        return $this->w->repository(ProjectRelease::class)->findOrFail($id);
    }
}
