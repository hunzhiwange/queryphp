<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Role;

use App\Domain\Service\Support\ReadParams;
use Leevel\Collection\TypedStringArray;

/**
 * 角色列表参数.
 */
class RolesParams extends ReadParams
{
    public ?int $status = null;

    public string $orderBy = 'id DESC';

    protected function columnDefaultValue(): TypedStringArray
    {
        return new TypedStringArray([
            'id', 'name', 'num',
            'status', 'create_at',
        ]);
    }

    protected function keyColumnDefaultValue(): TypedStringArray
    {
        return new TypedStringArray([
            'id', 'name', 'num',
        ]);
    }
}
