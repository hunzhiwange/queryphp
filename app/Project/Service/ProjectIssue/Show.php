<?php

declare(strict_types=1);

namespace App\Project\Service\ProjectIssue;

use App\Project\Entity\ProjectIssue;
use Leevel\Database\Condition;
use Leevel\Database\Ddd\UnitOfWork;

/**
 * 项目任务查询.
 */
class Show
{
    public function __construct(private UnitOfWork $w)
    {
    }

    public function handle(ShowParams $params): array
    {
        $entity = $this->find($params->num);

        return $entity->toArray();
    }

    private function find(string $num): ProjectIssue
    {
        return $this->w
            ->repository(ProjectIssue::class)
            ->eager([
                'project',
                'project_content',
                'project_label',
                'project_type',
                'project_releases',
                'project_tags',
                'project_modules',
            ])
            ->findOrFail(function (Condition $select) use ($num): void {
                $select->where('num', $num);
            })
        ;
    }
}
