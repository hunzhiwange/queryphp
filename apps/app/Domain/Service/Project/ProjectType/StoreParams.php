<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectType;

use Leevel\Support\Dto;

/**
 * 项目类型保存参数.
 */
class StoreParams extends Dto
{
    use BaseStoreUpdateParams;

    public int $contentType;
}
