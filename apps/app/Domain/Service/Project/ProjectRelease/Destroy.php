<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectRelease;

use App\Domain\Entity\Project\ProjectRelease;
use App\Domain\Service\Support\Destroy as CommonDestroy;

/**
 * 项目版本删除.
 */
class Destroy
{
    use CommonDestroy;

    /**
     * 返回实体.
     */
    private function entity(): string
    {
        return ProjectRelease::class;
    }
}
