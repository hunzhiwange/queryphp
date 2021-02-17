<?php

declare(strict_types=1);

namespace App\Domain\Service\Option;

use App\Domain\Entity\Base\Option;
use Leevel\Support\Dto;

class OptionUpdateParams extends Dto
{
    public string $siteName = '';

    public int $siteStatus = Option::SITE_STATUS_ENABLE;
}
