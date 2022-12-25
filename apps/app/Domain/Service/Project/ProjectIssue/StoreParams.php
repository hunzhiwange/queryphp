<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectIssue;

use App\Domain\Entity\Project\ProjectIssue;
use App\Domain\Service\Support\StoreParams as CommonStoreParams;

/**
 * 项目问题保存参数.
 */
class StoreParams extends CommonStoreParams
{
    public int $projectId;

    public int $projectLabelId;

    public int $projectTypeId;

    public string $title;

    protected string $entityClass = ProjectIssue::class;
}
