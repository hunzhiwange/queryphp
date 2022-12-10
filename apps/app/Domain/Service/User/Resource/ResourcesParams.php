<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Resource;

use App\Domain\Service\Support\ReadParams;
use Leevel\Support\TypedStringArray;

/**
 * 资源列表参数.
 */
class ResourcesParams extends ReadParams
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
