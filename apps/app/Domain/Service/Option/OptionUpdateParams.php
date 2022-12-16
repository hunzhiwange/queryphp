<?php

declare(strict_types=1);

namespace App\Domain\Service\Option;

use App\Domain\Entity\Base\SiteStatusEnum;
use Leevel\Support\Dto;

class OptionUpdateParams extends Dto
{
    public string $siteName = '';

    public int $siteStatus;

    protected function siteStatusDefaultValue(): int
    {
        return SiteStatusEnum::ENABLE->value;
    }
}
