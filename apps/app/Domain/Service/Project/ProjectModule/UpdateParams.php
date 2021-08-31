<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectModule;

use Leevel\Support\Dto;

/**
 * 项目模块更新参数.
 */
class UpdateParams extends Dto
{
    use BaseStoreUpdateParams;

    public int $id;
}
