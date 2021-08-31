<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectType;

trait BaseStoreUpdateParams
{
    public int $sort = 0;

    public string $name;

    public string $num;

    public string $icon;

    public int $status;

    public string $color;
}
