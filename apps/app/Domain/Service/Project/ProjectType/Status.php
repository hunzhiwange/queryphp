<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectType;

use App\Domain\Entity\Project\ProjectType;
use App\Domain\Service\Support\Status as CommonStatus;

/**
 * 批量修改项目类型状态.
 */
class Status
{
    use CommonStatus;

    protected string $entityClass = ProjectType::class;
}
