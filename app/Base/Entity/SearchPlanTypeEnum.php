<?php

declare(strict_types=1);

namespace App\Base\Entity;

use Leevel\Support\Enum;
use Leevel\Support\Msg;

/**
 * 常用搜索类型枚举.
 */
enum SearchPlanTypeEnum: int
{
    use Enum;

    #[Msg('搜索条件')]
    case SEARCH_CRITERIA = 1;

    #[Msg('列配置')]
    case COLUMN_CONFIGURATION = 2;
}
