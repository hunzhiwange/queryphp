<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\Project;

use App\Domain\Entity\Project\Project;
use App\Domain\Service\Support\Status as CommonStatus;

/**
 * 批量修改项目状态.
 */
class Status
{
    use CommonStatus;

    /**
     * 返回实体.
     */
    private function entity(): string
    {
        return Project::class;
    }
}
