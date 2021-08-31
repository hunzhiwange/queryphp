<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectModule;

use Leevel\Support\Dto;

/**
 * 项目模块保存参数.
 */
class StoreParams extends Dto
{
    use BaseStoreUpdateParams;

    public int $projectId;
}
