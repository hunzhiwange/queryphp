<?php

declare(strict_types=1);

namespace App\Project\Service\ProjectTag;

use App\Infra\Service\Support\StoreParams as CommonStoreParams;
use App\Infra\Validate\Project\ProjectTag as ProjectTagValidate;
use App\Project\Entity\ProjectTag;
use Leevel\Validate\UniqueRule;

/**
 * 项目标签保存参数.
 */
class StoreParams extends CommonStoreParams
{
    use BaseStoreUpdateParams;

    public string $validatorClass = ProjectTagValidate::class;

    public string $entityClass = ProjectTag::class;

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
