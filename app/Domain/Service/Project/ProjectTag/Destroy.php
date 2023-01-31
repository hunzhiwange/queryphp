<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectTag;

use App\Domain\Entity\Project\ProjectTag;
use App\Domain\Service\Support\Destroy as CommonDestroy;

/**
 * 项目标签删除.
 */
class Destroy
{
    use CommonDestroy;

    protected string $entityClass = ProjectTag::class;
}
