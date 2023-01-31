<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectType;

use App\Domain\Entity\Project\ProjectType;
use App\Domain\Service\Support\Read;

/**
 * 项目类型列表.
 */
class ProjectTypes
{
    use Read;

    protected string $entityClass = ProjectType::class;
}
