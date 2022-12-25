<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectModule;

use App\Domain\Entity\Project\ProjectModule;
use App\Domain\Service\Support\UpdateParams as CommonUpdateParams;
use App\Domain\Validate\Project\ProjectModule as ProjectModuleValidate;
use Leevel\Validate\UniqueRule;

/**
 * 项目模块更新参数.
 */
class UpdateParams extends CommonUpdateParams
{
    use BaseStoreUpdateParams;

    public int $id;

    protected string $validatorClass = ProjectModuleValidate::class;

    protected string $entityClass = ProjectModule::class;

    /**
     * {@inheritDoc}
     */
    protected function validatorClassArgs(): array
    {
        $uniqueRule = UniqueRule::rule(
            $this->entityClass,
            exceptId:$this->id,
            additional:['project_id' => $this->projectId]
        );

        return [$uniqueRule];
    }
}
