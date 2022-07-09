<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectIssue;

use App\Domain\Service\Support\Params\Project\ProjectIds;
use App\Domain\Service\Support\ReadParams;
use Leevel\Collection\TypedStringArray;

/**
 * 项目问题列表参数.
 */
class ProjectIssuesParams extends ReadParams
{
    use ProjectIds;

    public ?int $userId = null;

    public ?string $type = null;

    public string $orderBy = 'id DESC';

    protected function columnDefaultValue(): TypedStringArray
    {
        return new TypedStringArray([
            '*',
        ]);
    }

    protected function keyColumnDefaultValue(): TypedStringArray
    {
        return new TypedStringArray([
            'id', 'title',
        ]);
    }
}
