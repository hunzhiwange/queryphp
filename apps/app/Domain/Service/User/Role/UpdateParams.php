<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Role;

use Leevel\Support\Dto;

/**
 * 角色更新参数.
 */
class UpdateParams extends Dto
{
    use BaseStoreUpdateParams;

    public int $id;
}
