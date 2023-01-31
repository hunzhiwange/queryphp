<?php

declare(strict_types=1);

namespace App\Domain\Service\Support;

use App\Domain\Dto\ParamsDto;
use App\Domain\Validate\Support\Status;
use Leevel\Support\TypedIntArray;

class StatusParams extends ParamsDto
{
    public TypedIntArray $ids;

    public int $status;

    protected string $validatorClass = Status::class;

    protected function idsDefaultValue(): TypedIntArray
    {
        return new TypedIntArray([]);
    }

    protected function idsTransformValue(string|array $value): TypedIntArray
    {
        return TypedIntArray::fromRequest($value);
    }
}
