<?php

declare(strict_types=1);

namespace App\Project\Service\ProjectLabel;

use App\Infra\Service\Support\DestroyParams as CommonDestroyParams;
use App\Project\Entity\ProjectLabel;

class DestroyParams extends CommonDestroyParams
{
    public string $entityClass = ProjectLabel::class;
}
