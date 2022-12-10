<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectLabel;

use App\Domain\Service\Support\Params\Project\ProjectIds;
use App\Domain\Service\Support\ReadParams;
use Leevel\Support\TypedStringArray;

/**
 * 项目分类列表参数.
 */
class ProjectLabelsParams extends ReadParams
{
    use ProjectIds;

    public string $orderBy = 'project_id DESC,sort ASC,id DESC';

    protected function columnDefaultValue(): TypedStringArray
    {
        return new TypedStringArray([
            '*',
        ]);
    }

    protected function keyColumnDefaultValue(): TypedStringArray
    {
        return new TypedStringArray([
            'id', 'name',
        ]);
    }
}
