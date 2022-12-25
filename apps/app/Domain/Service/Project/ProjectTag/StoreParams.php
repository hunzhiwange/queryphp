<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectTag;

use App\Domain\Entity\Project\ProjectTag;
use App\Domain\Service\Support\StoreParams as CommonStoreParams;
use App\Domain\Validate\Project\ProjectTag as ProjectTagValidate;
use Leevel\Validate\UniqueRule;

/**
 * 项目标签保存参数.
 */
class StoreParams extends CommonStoreParams
{
    use BaseStoreUpdateParams;

    protected string $validatorClass = ProjectTagValidate::class;

    protected string $entityClass = ProjectTag::class;

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
