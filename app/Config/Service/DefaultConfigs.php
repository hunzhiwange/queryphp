<?php

declare(strict_types=1);

namespace App\Config\Service;

use App\Infra\Entity\EnabledEnum;
use Leevel\Support\Dto;

/**
 * 默认配置.
 */
class DefaultConfigs extends Dto
{
    /**
     * 站点名字.
     */
    public string $siteName = '';

    /**
     * 站点状态.
     */
    public int $siteStatus = 0;

    protected function siteStatusDefaultValue(): int
    {
        return EnabledEnum::ENABLE->value;
    }
}
