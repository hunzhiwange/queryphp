<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectLabel;

use App\Domain\Entity\Project\ProjectLabel;
use App\Domain\Service\Support\StoreParams as CommonStoreParams;
use Leevel\Validate\UniqueRule;
use App\Domain\Validate\Project\ProjectLabel as ProjectLabelValidate;

/**
 * 项目分类保存参数.
 */
class StoreParams extends CommonStoreParams
{
    use BaseStoreUpdateParams;

    protected string $validatorClass = ProjectLabelValidate::class;

    protected string $entityClass = ProjectLabel::class;

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
