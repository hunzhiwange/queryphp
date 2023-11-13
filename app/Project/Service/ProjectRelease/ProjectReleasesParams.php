<?php

declare(strict_types=1);

namespace App\Project\Service\ProjectRelease;

use App\Infra\Service\Support\ReadParams;
use App\Project\Entity\ProjectRelease;
use App\Project\Service\Support\ProjectIdsParams;
use Leevel\Support\VectorString;

/**
 * 项目版本列表参数.
 */
class ProjectReleasesParams extends ReadParams
{
    use ProjectIdsParams;

    public ?int $status = null;

    public ?string $orderBy = 'project_id DESC,sort DESC,id DESC';

    public string $entityClass = ProjectRelease::class;

    protected function columnDefaultValue(): VectorString
    {
        return new VectorString(['*']);
    }

    protected function keyColumnDefaultValue(): VectorString
    {
        return new VectorString([
            'id', 'name',
        ]);
    }
}
