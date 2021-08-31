<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\Project;

use Leevel\Support\Dto;

/**
 * 设为成员参数.
 */
class SetMemberParams extends Dto
{
    public int $userId;

    public int $projectId;
}
