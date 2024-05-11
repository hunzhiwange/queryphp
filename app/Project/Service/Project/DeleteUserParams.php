<?php

declare(strict_types=1);

namespace App\Project\Service\Project;

use Leevel\Support\Dto;

/**
 * 删除成员参数.
 */
class DeleteUserParams extends Dto
{
    public int $userId = 0;

    public int $projectId = 0;
}
