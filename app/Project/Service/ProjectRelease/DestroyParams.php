<?php

declare(strict_types=1);

namespace App\Project\Service\ProjectRelease;

use App\Infra\Service\Support\DestroyParams as CommonDestroyParams;
use App\Project\Entity\ProjectRelease;

class DestroyParams extends CommonDestroyParams
{
    public string $entityClass = ProjectRelease::class;
}
