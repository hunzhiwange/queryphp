<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectLabel;

use App\Domain\Entity\Project\ProjectLabel;
use App\Domain\Service\Support\StoreParams as CommonStoreParams;
use Leevel\Validate\UniqueRule;

/**
 * 项目分类保存参数.
 */
class StoreParams extends CommonStoreParams
{
    use BaseStoreUpdateParams;

    public int $projectId;

    protected string $entityClass = ProjectLabel::class;

    /**
     * {@inheritDoc}
     */
    protected function validatorClassArgs(): array
    {
        $uniqueRule = UniqueRule::rule(
            $this->entityClass,
            additional:['project_id' => $this->projectId]
        );

        return [$uniqueRule];
    }
}
