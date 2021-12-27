<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectIssue;

use App\Domain\Entity\Project\ProjectIssue;
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
        $result = $entity->toArray();

        return $result;
    }

    private function find(string $num): ProjectIssue
    {
        return $this->w
            ->repository(ProjectIssue::class)
            ->findOrFail(function (Condition $select) use ($num): void {
                $select->where('num', $num);
            });
    }
}
