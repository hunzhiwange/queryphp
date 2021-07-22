<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Permission;

use Leevel\Support\Dto;

/**
 * 权限更新参数.
 */
class UpdateParams extends Dto
{
    use BaseStoreUpdateParams;

    public int $id;
}
