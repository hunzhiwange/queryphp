<?php

declare(strict_types=1);

namespace App\Project\Service\ProjectType;

use App\Infra\Service\Support\DestroyParams as CommonDestroyParams;
use App\Project\Entity\ProjectType;

class DestroyParams extends CommonDestroyParams
{
    public string $entityClass = ProjectType::class;
}
