<?php

declare(strict_types=1);

namespace Common\Domain\Service\User\Resource;

use Common\Domain\Entity\User\Resource;
use Common\Domain\Service\Support\Status as CommonStatus;

/**
 * 批量修改资源状态.
 */
class Status
{
    use CommonStatus;

    /**
     * 返回实体.
     */
    private function entity(): string
    {
        return Resource::class;
    }
}
