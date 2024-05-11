<?php

declare(strict_types=1);

namespace App\Project\Service\ProjectTag;

use App\Infra\Service\Support\StatusParams as CommonStatusParams;
use App\Project\Entity\ProjectTag;

class StatusParams extends CommonStatusParams
{
    public string $entityClass = ProjectTag::class;
}
