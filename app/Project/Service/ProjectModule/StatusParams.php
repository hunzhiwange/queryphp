<?php

declare(strict_types=1);

namespace App\Project\Service\ProjectModule;

use App\Infra\Service\Support\StatusParams as CommonStatusParams;
use App\Project\Entity\ProjectModule;

class StatusParams extends CommonStatusParams
{
    public string $entityClass = ProjectModule::class;
}
