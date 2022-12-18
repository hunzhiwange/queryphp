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

    protected string $entityClass = ProjectRelease::class;
}
