<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectType;

use Leevel\Support\Dto;

/**
 * 项目类型更新参数.
 */
class UpdateParams extends Dto
{
    use BaseStoreUpdateParams;

    public int $id;
}
