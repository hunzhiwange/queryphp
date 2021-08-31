<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectType;

use App\Domain\Entity\Project\ProjectType;
use App\Domain\Service\Support\Read;
use App\Domain\Service\Project\ProjectType\ProjectTypesParams;

/**
 * 项目类型列表.
 */
class ProjectTypes
{
    use Read;

    public function handle(ProjectTypesParams $params): array
    {
        return $this->findLists($params, ProjectType::class);
    }
}
