<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectType;

use App\Domain\Service\Support\ReadParams;
use Leevel\Collection\TypedStringArray;

/**
 * 项目类型列表参数.
 */
class ProjectTypesParams extends ReadParams
{
    public ?int $status = null;

    public string $orderBy = 'sort ASC,id ASC';

    protected function columnDefaultValue(): TypedStringArray
    {
        return new TypedStringArray(['*']);
    }

    protected function keyColumnDefaultValue(): TypedStringArray
    {
        return new TypedStringArray([
            'id', 'name',
        ]);
    }
}
