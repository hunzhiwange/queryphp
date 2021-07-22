<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Permission;

use Leevel\Support\Dto;

/**
 * 权限保存参数.
 */
class StoreParams extends Dto
{
    use BaseStoreUpdateParams;
}
