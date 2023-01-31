<?php

declare(strict_types=1);

namespace App\Domain\Service\Support\Spec\Project;

use Leevel\Support\TypedIntArray;
use Leevel\Database\Ddd\Select;

/**
 * 项目 ID 条件.
 */
trait ProjectIds
{
    private function projectIdsSpec(Select $select, TypedIntArray $value): void
    {
        $select->whereIn('project_id', $value->toArray());
    }
}
