<?php

declare(strict_types=1);

namespace App\Project\Service\ProjectIssue;

use App\Infra\Service\Support\StoreParams as CommonStoreParams;
use App\Project\Entity\ProjectIssue;

/**
 * 项目问题保存参数.
 */
class StoreParams extends CommonStoreParams
{
    public int $projectId = 0;

    public int $projectLabelId = 0;

    public int $projectTypeId = 0;

    public string $title = '';

    public string $entityClass = ProjectIssue::class;
}
