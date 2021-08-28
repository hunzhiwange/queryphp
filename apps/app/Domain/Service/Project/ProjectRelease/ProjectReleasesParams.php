<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectRelease;

use App\Domain\Service\Support\ReadParams;
use Leevel\Collection\TypedStringArray;

/**
 * 项目发行版列表参数.
 */
class ProjectReleasesParams extends ReadParams
{
    public ?int $status = null;

    public string $orderBy = 'id DESC';

    protected function columnDefaultValue(): TypedStringArray
    {
        return new TypedStringArray([
            'id', 'name', 'num',
            'status', 'create_at',
        ]);
    }

    protected function keyColumnDefaultValue(): TypedStringArray
    {
        return new TypedStringArray([
            'id', 'name', 'num',
        ]);
    }
}
