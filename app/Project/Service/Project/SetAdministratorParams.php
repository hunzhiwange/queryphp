<?php

declare(strict_types=1);

namespace App\Project\Service\Project;

use Leevel\Support\Dto;

/**
 * 设为管理参数.
 */
class SetAdministratorParams extends Dto
{
    public int $userId = 0;

    public int $projectId = 0;
}
