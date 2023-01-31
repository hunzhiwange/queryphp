<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectLabel;

use App\Domain\Service\Support\UpdateParams as CommonUpdateParams;
use App\Domain\Validate\Project\ProjectLabel as ProjectLabelValidate;
use App\Domain\Entity\Project\ProjectLabel;
use Leevel\Validate\UniqueRule;

/**
 * 项目分类更新参数.
 */
class UpdateParams extends CommonUpdateParams
{
    use BaseStoreUpdateParams;

    public int $id;

    protected string $validatorClass = ProjectLabelValidate::class;

    protected string $entityClass = ProjectLabel::class;

    /**
     * {@inheritDoc}
     */
    protected function validatorArgs(): array
    {
        $uniqueRule = UniqueRule::rule(
            $this->entityClass,
            exceptId:$this->id,
            additional:['project_id' => $this->projectId]
        );

        return [$uniqueRule];
    }
}
