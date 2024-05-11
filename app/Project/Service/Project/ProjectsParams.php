<?php

declare(strict_types=1);

namespace App\Project\Service\Project;

use App\Infra\Service\Support\ReadParams;
use App\Project\Entity\Project;
use App\Project\Service\Support\ProjectIdsParams;
use Leevel\Support\VectorString;

/**
 * 项目列表参数.
 */
class ProjectsParams extends ReadParams
{
    use ProjectIdsParams;

    public ?int $status = null;

    public ?int $userId = null;

    public ?string $type = null;

    public ?string $orderBy = 'sort DESC,id DESC';

    public string $entityClass = Project::class;

    protected function columnDefaultValue(): VectorString
    {
        return new VectorString([
            '*',
        ]);
    }

    protected function keyColumnDefaultValue(): VectorString
    {
        return new VectorString([
            'id', 'name',
        ]);
    }
}
