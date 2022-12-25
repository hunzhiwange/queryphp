<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectType;

use App\Domain\Entity\Project\ProjectType;
use App\Domain\Service\Support\Store as CommonStore;

/**
 * 项目类型保存.
 */
class Store
{
    use CommonStore;

    protected string $entityClass = ProjectType::class;
}
