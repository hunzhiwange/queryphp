<?php

declare(strict_types=1);

namespace App\Infra\Service\Support;

use App\Infra\Dto\ParamsDto;
use App\Infra\Validate\Support\Status;
use Leevel\Support\VectorInt;

class StatusParams extends ParamsDto
{
    public ?VectorInt $ids = null;

    public int $status = 0;

    public string $validatorClass = Status::class;

    /**
     * 实体自动保存.
     */
    public bool $entityAutoFlush = true;

    protected function idsDefaultValue(): VectorInt
    {
        return new VectorInt([]);
    }

    protected function idsTransformValue(array|string $value): VectorInt
    {
        return VectorInt::fromRequest($value);
    }
}
