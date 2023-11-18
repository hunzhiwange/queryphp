<?php

declare(strict_types=1);

namespace App\Project\Service\ProjectModule;

use App\Infra\Service\Support\DestroyParams as CommonDestroyParams;
use App\Project\Entity\ProjectModule;

class DestroyParams extends CommonDestroyParams
{
    public string $entityClass = ProjectModule::class;
}
