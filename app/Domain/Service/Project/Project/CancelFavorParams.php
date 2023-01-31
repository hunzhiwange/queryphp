<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\Project;

use Leevel\Support\Dto;

/**
 * 取消项目收藏参数.
 */
class CancelFavorParams extends Dto
{
    public int $userId;

    public int $projectId;
}
