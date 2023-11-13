<?php

declare(strict_types=1);

namespace App\Config\Service;

use App\Infra\Entity\EnabledEnum;
use Leevel\Support\Dto;

class OptionUpdateParams extends Dto
{
    public string $siteName = '';

    public int $siteStatus = 0;

    protected function siteStatusDefaultValue(): int
    {
        return EnabledEnum::ENABLE->value;
    }
}
