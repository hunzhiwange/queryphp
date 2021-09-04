<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectRelease;

use Leevel\Support\Dto;

/**
 * 项目版本保存参数.
 */
class StoreParams extends Dto
{
    use BaseStoreUpdateParams;

    public int $projectId;
}
