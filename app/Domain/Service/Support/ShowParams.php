<?php

declare(strict_types=1);

namespace App\Domain\Service\Support;

use Leevel\Support\Dto;

/**
 * 通用查询参数.
 */
class ShowParams extends Dto
{
    public int $id = 0;
}
