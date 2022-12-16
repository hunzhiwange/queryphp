<?php

declare(strict_types=1);

namespace App\Domain\Service\Option;

use App\Domain\Entity\Base\SiteStatusEnum;
use Leevel\Support\Dto;

/**
 * 默认配置.
 */
class DefaultOptions extends Dto
{
    /**
     * 站点名字.
     */
    public string $siteName = '';

    /**
     * 站点状态.
     */
    public int $siteStatus;

    protected function siteStatusDefaultValue(): int
    {
        return SiteStatusEnum::ENABLE->value;
    }
}
