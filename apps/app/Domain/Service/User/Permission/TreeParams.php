<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Permission;

use Leevel\Support\Dto;

/**
 * 权限树列表参数.
 */
class TreeParams extends Dto
{
    public ?int $status = null;
}
