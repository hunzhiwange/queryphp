<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectLabel;

use App\Domain\Entity\Project\ProjectLabel;
use App\Domain\Service\Support\Read;
use App\Domain\Service\Support\Spec\Project\ProjectIds;

/**
 * 项目分类列表.
 */
class ProjectLabels
{
    use Read;
    use ProjectIds;

    public function handle(ProjectLabelsParams $params): array
    {
        return $this->findLists($params, ProjectLabel::class);
    }
}
