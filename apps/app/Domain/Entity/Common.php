<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use Leevel\Support\BaseEnum;

/**
 * 公共实体.
 */
class Common
{
    use BaseEnum;

    /**
     * 公共状态.
     */
    
    #[status('禁用')]
    public const STATUS_DISABLE = 0;

    #[status('启用')]
    public const STATUS_ENABLE = 1;
}
