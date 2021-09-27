<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectIssue;

use Leevel\Support\Dto;

/**
 * 项目问题保存参数.
 */
class StoreParams extends Dto
{
    public int $projectId;

    public int $projectLabelId;

    public int $projectTypeId;

    public string $title;
}
