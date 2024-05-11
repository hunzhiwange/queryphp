<?php

declare(strict_types=1);

namespace App\Project\Service\ProjectLabel;

use App\Infra\Service\Support\StoreParams as CommonStoreParams;
use App\Infra\Validate\Project\ProjectLabel as ProjectLabelValidate;
use App\Project\Entity\ProjectLabel;
use Leevel\Validate\UniqueRule;

/**
 * 项目分类保存参数.
 */
class StoreParams extends CommonStoreParams
{
    use BaseStoreUpdateParams;

    public string $validatorClass = ProjectLabelValidate::class;

    public string $entityClass = ProjectLabel::class;

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
