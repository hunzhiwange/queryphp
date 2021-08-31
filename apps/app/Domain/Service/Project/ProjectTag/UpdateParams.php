<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectTag;

use Leevel\Support\Dto;

/**
 * 项目标签更新参数.
 */
class UpdateParams extends Dto
{
    use BaseStoreUpdateParams;

    public int $id;
}
