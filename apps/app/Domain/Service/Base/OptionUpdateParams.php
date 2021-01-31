<?php

declare(strict_types=1);

namespace App\Domain\Service\Base;

use Leevel\Collection\TypedAssociativeArray;
use Leevel\Support\Dto;

class OptionUpdateParams extends Dto
{
    public TypedAssociativeArray $options;

    public static function fromRequest(array $data): static
    {
        $data = new TypedAssociativeArray($data);

        return new static(['options' => $data]);
    }
}
