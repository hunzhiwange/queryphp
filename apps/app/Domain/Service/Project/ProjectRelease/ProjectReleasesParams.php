<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectRelease;

use App\Domain\Service\Support\Params\Project\ProjectIds;
use App\Domain\Service\Support\ReadParams;
use Leevel\Collection\TypedStringArray;

/**
 * 项目版本列表参数.
 */
class ProjectReleasesParams extends ReadParams
{
    use ProjectIds;

    public ?int $status = null;

    public string $orderBy = 'sort ASC,id DESC';

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
