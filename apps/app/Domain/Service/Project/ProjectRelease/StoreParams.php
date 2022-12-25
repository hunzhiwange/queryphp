<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectRelease;

use App\Domain\Entity\Project\ProjectRelease;
use App\Domain\Service\Support\StoreParams as CommonStoreParams;
use App\Domain\Validate\Project\ProjectRelease as ProjectReleaseValidate;
use Leevel\Validate\UniqueRule;

/**
 * 项目版本保存参数.
 */
class StoreParams extends CommonStoreParams
{
    public int $sort = 0;

    public string $name;

    public int $status;

    public int $projectId = 0;

    protected string $validatorClass = ProjectReleaseValidate::class;

    protected string $entityClass = ProjectRelease::class;

    /**
     * {@inheritDoc}
     */
    protected function validatorClassArgs(): array
    {
        $uniqueRule = UniqueRule::rule(
            $this->entityClass,
            additional:['project_id' => $this->projectId]
        );

        return [$uniqueRule];
    }
}
