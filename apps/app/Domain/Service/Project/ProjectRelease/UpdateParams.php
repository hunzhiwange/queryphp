<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectRelease;

use App\Domain\Entity\Project\ProjectRelease;
use App\Domain\Entity\Project\ProjectReleaseCompletedEnum;
use App\Domain\Service\Support\UpdateParams as CommonUpdateParams;
use App\Domain\Validate\Project\ProjectRelease as ProjectReleaseValidate;
use Leevel\Validate\UniqueRule;

/**
 * 项目版本更新参数.
 */
class UpdateParams extends CommonUpdateParams
{
    public int $id;

    public ?int $sort = null;

    public ?string $name = null;

    public ?int $status = null;

    public ?int $completed = null;

    public ?string $completedDate = null;

    public int $projectId = 0;

    protected string $validatorClass = ProjectReleaseValidate::class;

    protected string $entityClass = ProjectRelease::class;

    /**
     * {@inheritDoc}
     */
    protected function beforeValidate(): void
    {
        if (ProjectReleaseCompletedEnum::PUBLISHED->value === $this->completed &&
            !isset($params->completedDate)) {
            $this->completedDate = \get_current_date();
        }
    }

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
