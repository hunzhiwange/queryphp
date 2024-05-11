<?php

declare(strict_types=1);

namespace App\Project\Service\Project;

use App\Infra\Service\Support\DestroyParams as CommonDestroyParams;

class DestroyParams extends CommonDestroyParams
{
    public string $entityClass = \App\Project\Entity\Project::class;
}
