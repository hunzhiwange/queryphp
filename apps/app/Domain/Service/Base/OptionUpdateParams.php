<?php

declare(strict_types=1);

namespace App\Domain\Service\Base;

use Leevel\Collection\TypedAssociativeStringArray;
use Leevel\Support\Dto;

class OptionUpdateParams extends Dto
{
    public TypedAssociativeStringArray $options;

    public static function fromRequest(array $data): static
    {
        // 校验数组类型
        array_walk(
            $data,
            fn(int|string|float $value, string $key) => $value,
        );
        $data = new TypedAssociativeStringArray($data);

        return new static(['options' => $data]);
    }
}
