<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectLabel;

use App\Domain\Entity\Project\ProjectLabel;
use App\Domain\Service\Support\Store as CommonStore;

/**
 * 项目分类保存.
 */
class Store
{
    use CommonStore;

    protected string $entityClass = ProjectLabel::class;
}
