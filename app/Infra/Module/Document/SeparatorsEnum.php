<?php

declare(strict_types=1);

namespace App\Infra\Module\Document;

enum SeparatorsEnum: string
{
    case UNDERLINE = '_';

    case POINT = '.';

    case DASH = '-';

    case BLANK = '';
}
