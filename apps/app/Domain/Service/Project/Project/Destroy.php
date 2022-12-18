<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\Project;

use App\Domain\Entity\Project\Project;
use App\Domain\Service\Support\Destroy as CommonDestroy;

/**
 * 项目删除.
 */
class Destroy
{
    use CommonDestroy;

    protected string $entityClass = Project::class;
}
