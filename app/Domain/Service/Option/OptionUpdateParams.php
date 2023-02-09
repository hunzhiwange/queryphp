<?php

declare(strict_types=1);

namespace App\Domain\Service\Option;

use App\Domain\Entity\StatusEnum;
use Leevel\Support\Dto;

class OptionUpdateParams extends Dto
{
    public string $siteName = '';

    public int $siteStatus = 0;

    protected function siteStatusDefaultValue(): int
    {
        return StatusEnum::ENABLE->value;
    }
}
