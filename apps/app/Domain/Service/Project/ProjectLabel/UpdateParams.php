<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectLabel;

use Leevel\Support\Dto;

/**
 * 项目分类更新参数.
 */
class UpdateParams extends Dto
{
    use BaseStoreUpdateParams;

    public int $id;
}
