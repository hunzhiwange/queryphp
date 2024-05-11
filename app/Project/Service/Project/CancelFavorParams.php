<?php

declare(strict_types=1);

namespace App\Project\Service\Project;

use Leevel\Support\Dto;

/**
 * 取消项目收藏参数.
 */
class CancelFavorParams extends Dto
{
    public int $userId = 0;

    public int $projectId = 0;
}
