<?php

declare(strict_types=1);

namespace App\Project\Service\ProjectModule;

use App\Infra\Service\Support\UpdateParams as CommonUpdateParams;
use App\Infra\Validate\Project\ProjectModule as ProjectModuleValidate;
use App\Project\Entity\ProjectModule;
use Leevel\Validate\UniqueRule;

/**
 * 项目模块更新参数.
 */
class UpdateParams extends CommonUpdateParams
{
    use BaseStoreUpdateParams;

    public int $id = 0;

    public string $validatorClass = ProjectModuleValidate::class;

    public string $entityClass = ProjectModule::class;

    /**
     * {@inheritDoc}
     */
    protected function validatorArgs(): array
    {
        $uniqueRule = UniqueRule::rule(
            $this->entityClass,
            exceptId: $this->id,
            additional: ['project_id' => $this->projectId]
        );

        return [$uniqueRule];
    }
}
