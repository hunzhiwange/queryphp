<?php

declare(strict_types=1);

namespace App\Infra\Service\Support\Update;

enum DataActionEnum
{
    case CHANGE;

    case EQUAL;
}
