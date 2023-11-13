<?php

declare(strict_types=1);

namespace App\Project\Service\ProjectModule;

use App\Infra\Service\Support\StoreParams as CommonStoreParams;
use App\Infra\Validate\Project\ProjectModule as ProjectModuleValidate;
use App\Project\Entity\ProjectModule;
use Leevel\Validate\UniqueRule;

/**
 * 项目模块保存参数.
 */
class StoreParams extends CommonStoreParams
{
    use BaseStoreUpdateParams;

    public string $validatorClass = ProjectModuleValidate::class;

    public string $entityClass = ProjectModule::class;

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
