<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\Project;

use Leevel\Support\Dto;

/**
 * 设为管理参数.
 */
class SetAdministratorParams extends Dto
{
    public int $userId = 0;

    public int $projectId = 0;
}
