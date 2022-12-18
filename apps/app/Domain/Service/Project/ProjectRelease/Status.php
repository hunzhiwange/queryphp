<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectRelease;

use App\Domain\Entity\Project\ProjectRelease;
use App\Domain\Service\Support\Status as CommonStatus;

/**
 * 批量修改项目版本状态.
 */
class Status
{
    use CommonStatus;

    protected string $entityClass = ProjectRelease::class;
}
