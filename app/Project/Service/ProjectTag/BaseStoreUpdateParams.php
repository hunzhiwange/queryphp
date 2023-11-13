<?php

declare(strict_types=1);

namespace App\Project\Service\ProjectTag;

trait BaseStoreUpdateParams
{
    public int $sort = 0;

    public string $name = '';

    public int $status = 0;

    public string $color = '';

    public int $projectId = 0;
}
