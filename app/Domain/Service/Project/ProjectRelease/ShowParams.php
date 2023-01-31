<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectRelease;

use Leevel\Support\Dto;

/**
 * 项目版本查询参数.
 */
class ShowParams extends Dto
{
    public int $id;
}
