<?php

declare(strict_types=1);

namespace App\Project\Service\ProjectTag;

use App\Infra\Service\Support\UpdateParams as CommonUpdateParams;
use App\Infra\Validate\Project\ProjectTag as ProjectTagValidate;
use App\Project\Entity\ProjectTag;
use Leevel\Validate\UniqueRule;

/**
 * 项目标签更新参数.
 */
class UpdateParams extends CommonUpdateParams
{
    use BaseStoreUpdateParams;

    public int $id = 0;

    public string $validatorClass = ProjectTagValidate::class;

    public string $entityClass = ProjectTag::class;

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
