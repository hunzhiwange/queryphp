<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectTag;

use Leevel\Support\Dto;

/**
 * 项目标签保存参数.
 */
class StoreParams extends Dto
{
    use BaseStoreUpdateParams;

    public int $projectId;
}
