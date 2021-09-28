<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectLabel;

use Leevel\Support\Dto;

/**
 * 项目分类保存参数.
 */
class StoreParams extends Dto
{
    use BaseStoreUpdateParams;

    public int $projectId;
}
