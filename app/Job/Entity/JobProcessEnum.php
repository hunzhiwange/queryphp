<?php

declare(strict_types=1);

namespace App\Job\Entity;

use Leevel\Support\Enum;
use Leevel\Support\Msg;

enum JobProcessEnum: int
{
    use Enum;

    #[Msg('待处理')]
    case PENDING = 0;

    #[Msg('处理成功')]
    case PROCESSED_SUCCESSFULLY = 1;

    #[Msg('处理失败')]
    case PROCESSING_FAILED = 2;
}
