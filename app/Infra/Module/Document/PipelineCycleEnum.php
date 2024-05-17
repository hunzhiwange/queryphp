<?php

declare(strict_types=1);

namespace App\Infra\Module\Document;

enum PipelineCycleEnum: string
{
    case DAY = 'Ymd';

    case MONTH = 'Ym';

    case YEAR = 'Y';

    case FOREVER = '';
}
