<?php

declare(strict_types=1);

namespace App\Project\Service\ProjectModule;

use App\Infra\Service\Support\ReadParams;
use App\Project\Entity\ProjectModule;
use Leevel\Support\VectorString;

/**
 * 项目模块列表参数.
 */
class ProjectModulesParams extends ReadParams
{
    public ?int $status = null;

    public ?string $orderBy = 'project_id DESC,sort DESC,id DESC';

    public string $entityClass = ProjectModule::class;

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
