<?php

declare(strict_types=1);

namespace App\Project\Service\Project;

use App\Infra\Service\Support\StatusParams as CommonStatusParams;
use App\Project\Entity\Project;

class StatusParams extends CommonStatusParams
{
    public string $entityClass = Project::class;
}
