<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectLabel;

trait BaseStoreUpdateParams
{
    public int $sort = 0;

    public string $name = '';

    public int $status = 0;

    public int $projectId = 0;
}
