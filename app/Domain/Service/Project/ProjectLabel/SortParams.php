<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectLabel;

use App\Domain\Dto\ParamsDto;
use App\Exceptions\ProjectBusinessException;
use App\Exceptions\ProjectErrorCode;
use Leevel\Support\TypedIntArray;

/**
 * 项目分类排序参数.
 */
class SortParams extends ParamsDto
{
    public int $projectId = 0;

    public ?TypedIntArray $projectLabelIds = null;

    protected function projectLabelIdsTransformValue(string|array $value): TypedIntArray
    {
        return TypedIntArray::fromRequest($value);
    }

    /**
     * {@inheritDoc}
     */
    protected function beforeValidate(): void
    {
        if ($this->projectLabelIds->isEmpty()) {
            throw new ProjectBusinessException(ProjectErrorCode::PROJECT_LABEL_SORT_PROJECT_LABEL_IDS_IS_EMPTY);
        }

        $projectLabelIds = $this->projectLabelIds->toArray();
        if (\count($projectLabelIds) !== \count(array_unique($projectLabelIds))) {
            throw new ProjectBusinessException(ProjectErrorCode::PROJECT_LABEL_SORT_PROJECT_LABEL_IDS_EXISTS_SAME_ID);
        }
    }
}
