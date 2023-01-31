<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectTag;

use App\Domain\Entity\Project\ProjectTag;
use App\Domain\Service\Support\Status as CommonStatus;

/**
 * 批量修改项目标签状态.
 */
class Status
{
    use CommonStatus;

    protected string $entityClass = ProjectTag::class;
}
