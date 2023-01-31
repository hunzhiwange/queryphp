<?php

declare(strict_types=1);

namespace App\Domain\Service\User\User;

use App\Domain\Service\Support\ReadParams;
use Leevel\Support\TypedStringArray;

/**
 * 用户列表参数.
 */
class UsersParams extends ReadParams
{
    public ?int $status = null;

    public string $orderBy = 'id DESC';

    protected function columnDefaultValue(): TypedStringArray
    {
        return new TypedStringArray([
            'id', 'name', 'num', 'email',
            'mobile', 'status', 'create_at',
        ]);
    }

    protected function keyColumnDefaultValue(): TypedStringArray
    {
        return new TypedStringArray([
            'id', 'name', 'num',
        ]);
    }
}
