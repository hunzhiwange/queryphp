<?php

declare(strict_types=1);

namespace App\Project\Service\ProjectIssue;

use App\Infra\Service\Support\DestroyParams as CommonDestroyParams;
use App\Project\Entity\ProjectIssue;

class DestroyParams extends CommonDestroyParams
{
    public string $entityClass = ProjectIssue::class;
}
