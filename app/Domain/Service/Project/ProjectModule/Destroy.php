<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectModule;

use App\Domain\Entity\Project\ProjectModule;
use App\Domain\Service\Support\Destroy as CommonDestroy;

/**
 * 项目模块删除.
 */
class Destroy
{
    use CommonDestroy;

    protected string $entityClass = ProjectModule::class;
}
