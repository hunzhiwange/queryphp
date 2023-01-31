<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectLabel;

use App\Domain\Entity\Project\ProjectLabel;
use App\Domain\Service\Support\Destroy as CommonDestroy;

/**
 * 项目分类删除.
 */
class Destroy
{
    use CommonDestroy;

    protected string $entityClass = ProjectLabel::class;
}
