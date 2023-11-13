<?php

declare(strict_types=1);

namespace App\Project\Service\Support;

use Leevel\Support\VectorInt;

trait ProjectIdsParams
{
    public ?VectorInt $projectIds = null;

    protected function projectIdsTransformValue(string|array $value): VectorInt
    {
        return VectorInt::fromRequest($value);
    }
}
