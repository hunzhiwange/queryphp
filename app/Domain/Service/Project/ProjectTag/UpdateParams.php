<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectTag;

use App\Domain\Entity\Project\ProjectTag;
use App\Domain\Service\Support\UpdateParams as CommonUpdateParams;
use App\Domain\Validate\Project\ProjectTag as ProjectTagValidate;
use Leevel\Validate\UniqueRule;

/**
 * 项目标签更新参数.
 */
class UpdateParams extends CommonUpdateParams
{
    use BaseStoreUpdateParams;

    public int $id;

    protected string $validatorClass = ProjectTagValidate::class;

    protected string $entityClass = ProjectTag::class;

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
