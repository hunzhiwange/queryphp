<?php

declare(strict_types=1);

namespace App\Project\Service\ProjectLabel;

use App\Infra\Service\Support\ReadParams;
use App\Project\Entity\ProjectLabel;
use App\Project\Service\Support\ProjectIdsParams;
use Leevel\Support\VectorString;

/**
 * 项目分类列表参数.
 */
class ProjectLabelsParams extends ReadParams
{
    use ProjectIdsParams;

    public ?string $orderBy = 'project_id DESC,sort DESC,id DESC';

    public string $entityClass = ProjectLabel::class;

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
