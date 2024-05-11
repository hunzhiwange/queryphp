<?php

declare(strict_types=1);

namespace App\Project\Service\ProjectType;

use App\Infra\Service\Support\ReadParams;
use App\Project\Entity\ProjectType;
use Leevel\Support\VectorString;

/**
 * 项目类型列表参数.
 */
class ProjectTypesParams extends ReadParams
{
    public ?int $status = null;

    public ?string $orderBy = 'sort DESC,id DESC';

    public string $entityClass = ProjectType::class;

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
