<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectType;

use App\Domain\Entity\Project\ProjectType;
use App\Domain\Service\Support\Update as CommonUpdate;

/**
 * 项目类型更新.
 */
class Update
{
    use CommonUpdate;

    protected string $entityClass = ProjectType::class;
}
