<?php

declare(strict_types=1);

namespace App\Project\Service\ProjectType;

use App\Infra\Service\Support\StoreParams as CommonStoreParams;
use App\Infra\Validate\Project\ProjectType as ProjectTypeValidate;
use App\Project\Entity\ProjectType;

/**
 * 项目类型保存参数.
 */
class StoreParams extends CommonStoreParams
{
    use BaseStoreUpdateParams;

    public int $contentType = 0;

    public string $entityClass = ProjectType::class;

    public string $validatorClass = ProjectTypeValidate::class;
}
