<?php

declare(strict_types=1);

namespace App\Domain\Service\Support;

use Leevel\Support\Dto;
use Leevel\Support\TypedStringArray;

/**
 * 查询参数.
 */
class ReadParams extends Dto
{
    public int $page = 1;

    public int $size = 10;

    public ?string $key = null;

    public ?TypedStringArray $column = null;

    public ?TypedStringArray $keyColumn = null;

    protected function columnTransformValue(array|string $value): TypedStringArray
    {
        if (\is_string($value)) {
            $value = explode(',', $value);
        }

        return new TypedStringArray($value);
    }
}
