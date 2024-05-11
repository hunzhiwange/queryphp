<?php

declare(strict_types=1);

namespace App\Project\Service\ProjectRelease;

use App\Infra\Service\Support\UpdateParams as CommonUpdateParams;
use App\Infra\Validate\Project\ProjectRelease as ProjectReleaseValidate;
use App\Project\Entity\ProjectRelease;
use App\Project\Entity\ProjectReleaseCompletedEnum;
use Leevel\Validate\UniqueRule;
use function get_current_date;

/**
 * 项目版本更新参数.
 */
class UpdateParams extends CommonUpdateParams
{
    public int $id = 0;

    public ?int $sort = null;

    public ?string $name = null;

    public ?int $status = null;

    public ?int $completed = null;

    public ?string $completedDate = null;

    public string $validatorClass = ProjectReleaseValidate::class;

    public string $entityClass = ProjectRelease::class;

    /**
     * {@inheritDoc}
     */
    protected function beforeValidate(): void
    {
        if (ProjectReleaseCompletedEnum::PUBLISHED->value === $this->completed
            && !isset($this->completedDate)) {
            $this->completedDate = get_current_date();
        }
    }

    /**
     * {@inheritDoc}
     */
    protected function validatorArgs(): array
    {
        $uniqueRule = UniqueRule::rule(
            $this->entityClass,
            exceptId: $this->id,
        );

        return [$uniqueRule];
    }
}
