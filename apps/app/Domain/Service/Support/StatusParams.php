<?php

declare(strict_types=1);

namespace App\Domain\Service\Support;

use App\Domain\Validate\ValidateParams;
use Leevel\Support\TypedIntArray;
use Leevel\Support\Dto;
use App\Domain\Validate\Support\Status;

class StatusParams extends Dto
{
    use ValidateParams;

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

    /**
     * 校验基本参数.
     */
    public function validate(): void
    {
        $this->baseValidate(
            new Status(),
        );
    }
}
