<?php

declare(strict_types=1);

namespace App\Project\Service\ProjectRelease;

use App\Infra\Service\Support\StatusParams as CommonStatusParams;
use App\Project\Entity\ProjectRelease;

class StatusParams extends CommonStatusParams
{
    public string $entityClass = ProjectRelease::class;
}
