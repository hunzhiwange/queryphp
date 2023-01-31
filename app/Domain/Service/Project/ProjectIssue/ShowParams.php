<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectIssue;

use Leevel\Support\Dto;

/**
 * 项目任务查询参数.
 */
class ShowParams extends Dto
{
    public string $num;
}
