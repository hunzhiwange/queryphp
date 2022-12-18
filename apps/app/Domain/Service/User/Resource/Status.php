<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Resource;

use App\Domain\Entity\User\Resource;
use App\Domain\Service\Support\Status as CommonStatus;

/**
 * 批量修改资源状态.
 */
class Status
{
    use CommonStatus;

    protected string $entityClass = Resource::class;
}
