<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Permission;

use Leevel\Support\Dto;

/**
 * 权限查询参数.
 */
class ShowParams extends Dto
{
    public int $id;
}
