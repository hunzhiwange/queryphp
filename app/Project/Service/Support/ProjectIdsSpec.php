<?php

declare(strict_types=1);

namespace App\Project\Service\Support;

use Leevel\Database\Ddd\Select;
use Leevel\Support\VectorInt;

trait ProjectIdsSpec
{
    private function projectIdsSpec(Select $select, VectorInt $value): void
    {
        $select->whereIn('project_id', $value->toArray());
    }
}