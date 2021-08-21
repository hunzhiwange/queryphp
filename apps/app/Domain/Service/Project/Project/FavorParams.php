<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\Project;

use Leevel\Support\Dto;

/**
 * 项目收藏参数.
 */
class FavorParams extends Dto
{
    public int $userId;

    public int $projectId;
}
