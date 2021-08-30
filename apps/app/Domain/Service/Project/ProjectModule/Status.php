<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectModule;

use App\Domain\Entity\Project\ProjectModule;
use App\Domain\Service\Support\Status as CommonStatus;

/**
 * 批量修改项目模块状态.
 */
class Status
{
    use CommonStatus;

    /**
     * 返回实体.
     */
    private function entity(): string
    {
        return ProjectModule::class;
    }
}
