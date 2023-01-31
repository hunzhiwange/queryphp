<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectType;

use App\Domain\Entity\Project\ProjectType;
use App\Domain\Service\Support\Destroy as CommonDestroy;

/**
 * 项目类型删除.
 */
class Destroy
{
    use CommonDestroy;

    protected string $entityClass = ProjectType::class;
}
