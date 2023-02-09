<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectType;

use App\Domain\Entity\Project\ProjectType;
use App\Domain\Service\Support\StoreParams as CommonStoreParams;
use App\Domain\Validate\Project\ProjectType as ProjectTypeValidate;

/**
 * 项目类型保存参数.
 */
class StoreParams extends CommonStoreParams
{
    use BaseStoreUpdateParams;

    public int $contentType = 0;

    protected string $entityClass = ProjectType::class;

    protected string $validatorClass = ProjectTypeValidate::class;
}
