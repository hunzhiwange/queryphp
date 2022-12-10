<?php

declare(strict_types=1);

namespace App\Domain\Service\Support;

use Leevel\Support\TypedIntArray;
use Leevel\Support\Dto;

class StatusParams extends Dto
{
    public TypedIntArray $ids;

    public int $status;

    protected function idsDefaultValue(): TypedIntArray
    {
        return new TypedIntArray([]);
    }

    protected function idsTransformValue(string|array $value): TypedIntArray
    {
        return TypedIntArray::fromRequest($value);
    }
}
