<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectRelease;

use App\Domain\Entity\Project\ProjectRelease;
use App\Domain\Service\Support\Store as CommonStore;

/**
 * 项目版本保存.
 */
class Store
{
    use CommonStore;

    protected string $entityClass = ProjectRelease::class;
}
