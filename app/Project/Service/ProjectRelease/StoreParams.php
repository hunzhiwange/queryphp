<?php

declare(strict_types=1);

namespace App\Project\Service\ProjectRelease;

use App\Infra\Service\Support\StoreParams as CommonStoreParams;
use App\Infra\Validate\Project\ProjectRelease as ProjectReleaseValidate;
use App\Project\Entity\ProjectRelease;
use Leevel\Validate\UniqueRule;

/**
 * 项目版本保存参数.
 */
class StoreParams extends CommonStoreParams
{
    public int $sort = 0;

    public string $name = '';

    public int $status = 0;

    public int $projectId = 0;

    public string $validatorClass = ProjectReleaseValidate::class;

    public string $entityClass = ProjectRelease::class;

    /**
     * {@inheritDoc}
     */
    protected function validatorArgs(): array
    {
        $uniqueRule = UniqueRule::rule(
            $this->entityClass,
            additional: ['project_id' => $this->projectId]
        );

        return [$uniqueRule];
    }
}
