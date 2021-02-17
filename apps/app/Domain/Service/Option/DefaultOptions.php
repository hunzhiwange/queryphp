<?php

declare(strict_types=1);

namespace App\Domain\Service\Option;

use App\Domain\Entity\Base\Option as EntityOption;
use Leevel\Support\Enum;

/**
 * 默认配置.
 */
class DefaultOptions extends Enum
{
    #[option('站点名字')]
    const SITE_NAME = '';

    #[option('站点状态')]
    const SITE_STATUS = EntityOption::SITE_STATUS_ENABLE;
}
