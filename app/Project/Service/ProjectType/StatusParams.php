<?php

declare(strict_types=1);

namespace App\Project\Service\ProjectType;

use App\Infra\Service\Support\StatusParams as CommonStatusParams;
use App\Project\Entity\ProjectType;

class StatusParams extends CommonStatusParams
{
    public string $entityClass = ProjectType::class;
}
