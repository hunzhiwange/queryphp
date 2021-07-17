<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Role;

use Leevel\Support\Dto;

/**
 * 角色查询参数.
 */
class ShowParams extends Dto
{
    public int $id;
}
