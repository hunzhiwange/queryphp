<?php

declare(strict_types=1);

namespace App\Project\Service\ProjectTag;

use App\Infra\Service\Support\ReadParams;
use App\Project\Entity\ProjectTag;
use Leevel\Support\VectorString;

/**
 * 项目标签列表参数.
 */
class ProjectTagsParams extends ReadParams
{
    public ?int $status = null;

    public ?string $orderBy = 'project_id DESC,sort DESC,id DESC';

    public string $entityClass = ProjectTag::class;

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
