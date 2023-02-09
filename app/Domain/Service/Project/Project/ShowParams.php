<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\Project;

use Leevel\Support\Dto;

/**
 * 项目查询参数.
 */
class ShowParams extends Dto
{
    public string $num = '';
}
