<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectType;

use App\Domain\Entity\Project\ProjectType;
use App\Domain\Service\Support\UpdateParams as CommonUpdateParams;
use App\Domain\Validate\Project\ProjectType as ProjectTypeValidate;

/**
 * 项目类型更新参数.
 */
class UpdateParams extends CommonUpdateParams
{
    use BaseStoreUpdateParams;

    public int $id;

    protected string $validatorClass = ProjectTypeValidate::class;

    protected string $entityClass = ProjectType::class;
}
