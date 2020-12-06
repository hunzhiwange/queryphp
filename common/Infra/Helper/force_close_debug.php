<?php

declare(strict_types=1);

namespace Common\Infra\Helper;

use Leevel\Option\Proxy\Option;

/**
 * 强制关闭调试模式.
 */
function force_close_debug(): void
{
    Option::set('debug', false);
}

class force_close_debug
{
}
