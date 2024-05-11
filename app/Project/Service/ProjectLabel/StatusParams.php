<?php

declare(strict_types=1);

namespace App\Project\Service\ProjectLabel;

use App\Infra\Service\Support\StatusParams as CommonStatusParams;
use App\Project\Entity\ProjectLabel;

class StatusParams extends CommonStatusParams
{
    public string $entityClass = ProjectLabel::class;
}
