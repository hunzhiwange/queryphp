<?php

declare(strict_types=1);

namespace App\Project\Service\ProjectLabel;

use App\Infra\Service\Support\UpdateParams as CommonUpdateParams;
use App\Infra\Validate\Project\ProjectLabel as ProjectLabelValidate;
use App\Project\Entity\ProjectLabel;
use Leevel\Validate\UniqueRule;

/**
 * 项目分类更新参数.
 */
class UpdateParams extends CommonUpdateParams
{
    use BaseStoreUpdateParams;

    public int $id = 0;

    public string $validatorClass = ProjectLabelValidate::class;

    public string $entityClass = ProjectLabel::class;

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
