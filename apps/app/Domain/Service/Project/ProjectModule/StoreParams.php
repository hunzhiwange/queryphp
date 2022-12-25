<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectModule;

use App\Domain\Service\Support\StoreParams as CommonStoreParams;
use App\Domain\Validate\Project\ProjectModule as ProjectModuleValidate;
use App\Domain\Entity\Project\ProjectModule;
use Leevel\Validate\UniqueRule;

/**
 * 项目模块保存参数.
 */
class StoreParams extends CommonStoreParams
{
    use BaseStoreUpdateParams;

    protected string $validatorClass = ProjectModuleValidate::class;

    protected string $entityClass = ProjectModule::class;

    /**
     * {@inheritDoc}
     */
    protected function validatorArgs(): array
    {
        $uniqueRule = UniqueRule::rule(
            $this->entityClass,
            additional:['project_id' => $this->projectId]
        );

        return [$uniqueRule];
    }
}
