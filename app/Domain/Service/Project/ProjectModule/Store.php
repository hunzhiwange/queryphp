<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectModule;

use App\Domain\Entity\Project\ProjectModule;
use App\Domain\Service\Support\Store as CommonStore;

/**
 * 项目模块保存.
 */
class Store
{
    use CommonStore;

    protected string $entityClass = ProjectModule::class;
}
