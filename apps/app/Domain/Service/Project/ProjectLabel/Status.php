<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectLabel;

use App\Domain\Entity\Project\ProjectLabel;
use App\Domain\Service\Support\Status as CommonStatus;

/**
 * 批量修改项目分类状态.
 */
class Status
{
    use CommonStatus;

    protected string $entityClass = ProjectLabel::class;
}
