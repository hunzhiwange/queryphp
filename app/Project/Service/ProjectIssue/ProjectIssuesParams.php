<?php

declare(strict_types=1);

namespace App\Project\Service\ProjectIssue;

use App\Infra\Service\Support\ReadParams;
use App\Project\Entity\ProjectIssue;
use App\Project\Service\Support\ProjectIdsParams;
use Leevel\Support\VectorString;

/**
 * 项目问题列表参数.
 */
class ProjectIssuesParams extends ReadParams
{
    use ProjectIdsParams;

    public ?int $userId = null;

    public ?string $type = null;

    public ?string $orderBy = 'id DESC';

    public string $entityClass = ProjectIssue::class;

    protected function columnDefaultValue(): VectorString
    {
        return new VectorString([
            '*',
        ]);
    }

    protected function keyColumnDefaultValue(): VectorString
    {
        return new VectorString([
            'id', 'title',
        ]);
    }
}
