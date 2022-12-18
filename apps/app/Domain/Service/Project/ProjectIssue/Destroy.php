<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectIssue;

use App\Domain\Entity\Project\ProjectIssue;
use App\Domain\Service\Support\Destroy as CommonDestroy;

/**
 * 项目问题删除.
 */
class Destroy
{
    use CommonDestroy;

    protected string $entityClass = ProjectIssue::class;
}
