<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectTag;

use App\Domain\Entity\Project\ProjectTag;
use App\Domain\Service\Support\Store as CommonStore;

/**
 * 项目标签保存.
 */
class Store
{
    use CommonStore;

    protected string $entityClass = ProjectTag::class;
}
