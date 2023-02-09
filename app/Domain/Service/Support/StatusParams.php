<?php

declare(strict_types=1);

namespace App\Domain\Service\Support;

use App\Domain\Dto\ParamsDto;
use App\Domain\Validate\Support\Status;
use Leevel\Support\TypedIntArray;

class StatusParams extends ParamsDto
{
    public ?TypedIntArray $ids = null;

    public int $status = 0;

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
