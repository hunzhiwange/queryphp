<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\Project;

use App\Domain\Service\Support\ReadParams;
use Leevel\Collection\TypedStringArray;

/**
 * 项目用户列表参数.
 */
class UsersParams extends ReadParams
{
    public ?int $projectId = null;

    public string $orderBy = 'id DESC';

    protected function columnDefaultValue(): TypedStringArray
    {
        return new TypedStringArray([
            '*',
        ]);
    }

    protected function keyColumnDefaultValue(): TypedStringArray
    {
        return new TypedStringArray([
            'user.id', 'user.name', 'user.num',
        ]);
    }
}
