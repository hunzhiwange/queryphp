<?php

declare(strict_types=1);

namespace App\Domain\Service\Support\Params\Project;

use Leevel\Collection\TypedIntArray;

trait ProjectIds
{
    public ?TypedIntArray $projectIds = null;

    protected function projectIdsTransformValue(string|array $value): TypedIntArray
    {
        return TypedIntArray::fromRequest($value);
    }
}
