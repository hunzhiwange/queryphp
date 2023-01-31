<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectTag;

use App\Domain\Service\Support\ReadParams;
use Leevel\Support\TypedStringArray;

/**
 * 项目标签列表参数.
 */
class ProjectTagsParams extends ReadParams
{
    public ?int $status = null;

    public string $orderBy = 'project_id DESC,sort ASC,id DESC';

    protected function columnDefaultValue(): TypedStringArray
    {
        return new TypedStringArray(['*']);
    }

    protected function keyColumnDefaultValue(): TypedStringArray
    {
        return new TypedStringArray([
            'id', 'name',
        ]);
    }
}
