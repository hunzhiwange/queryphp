<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectRelease;

use App\Domain\Entity\Project\ProjectRelease;
use App\Domain\Service\Support\Read;
use App\Domain\Service\Project\ProjectRelease\ProjectReleasesParams;

/**
 * 项目发行版列表.
 */
class ProjectReleases
{
    use Read;

    public function handle(ProjectReleasesParams $params): array
    {
        return $this->findLists($params, ProjectRelease::class);
    }
}
