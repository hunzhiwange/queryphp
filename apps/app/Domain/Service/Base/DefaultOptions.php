<?php

declare(strict_types=1);

namespace App\Domain\Service\Base;

use Leevel\Support\Enum;

/**
 * 默认配置.
 */
class DefaultOptions extends Enum
{
    #[option('站点名字')]
    const SITE_NAME = '';

    #[option('站点关闭状态')]
    const SITE_CLOSE = 0;
}
