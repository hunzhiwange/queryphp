<?php

declare(strict_types=1);

namespace App\Domain\Service\User\User;

use Leevel\Collection\TypedIntArray;
use Leevel\Support\Dto;

/**
 * 用户更新参数.
 */
class UpdateParams extends Dto
{
    use BaseStoreUpdateParams;

    public int $id;

    public string $password = '';
    
    public TypedIntArray $userRole;
}
