<?php

declare(strict_types=1);

namespace App\Project\Service\ProjectTag;

use App\Infra\Service\Support\DestroyParams as CommonDestroyParams;
use App\Project\Entity\ProjectTag;

class DestroyParams extends CommonDestroyParams
{
    public string $entityClass = ProjectTag::class;
}
