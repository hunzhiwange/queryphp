<?php

declare(strict_types=1);

namespace App\Project\Service\ProjectRelease;

use Leevel\Support\Dto;

/**
 * 项目版本查询参数.
 */
class ShowParams extends Dto
{
    public int $id = 0;
}
