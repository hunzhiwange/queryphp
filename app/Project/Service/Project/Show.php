<?php

declare(strict_types=1);

namespace App\Project\Service\Project;

use App\Project\Entity\Project;
use Leevel\Database\Condition;
use Leevel\Database\Ddd\UnitOfWork;

/**
 * 项目查询.
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

    private function find(string $num): Project
    {
        return $this->w
            ->repository(\App\Project\Entity\Project::class)
            ->findOrFail(function (Condition $select) use ($num): void {
                $select->where('num', $num);
            })
        ;
    }
}
