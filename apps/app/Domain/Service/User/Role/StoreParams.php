<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Role;

use Leevel\Support\Dto;

/**
 * 角色保存参数.
 */
class StoreParams extends Dto
{
    use BaseStoreUpdateParams;
}
