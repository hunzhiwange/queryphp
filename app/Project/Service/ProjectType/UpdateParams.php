<?php

declare(strict_types=1);

namespace App\Project\Service\ProjectType;

use App\Infra\Service\Support\UpdateParams as CommonUpdateParams;
use App\Infra\Validate\Project\ProjectType as ProjectTypeValidate;
use App\Project\Entity\ProjectType;

/**
 * 项目类型更新参数.
 */
class UpdateParams extends CommonUpdateParams
{
    use BaseStoreUpdateParams;

    public int $id = 0;

    public string $validatorClass = ProjectTypeValidate::class;

    public string $entityClass = ProjectType::class;
}
