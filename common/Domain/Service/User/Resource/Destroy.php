<?php

declare(strict_types=1);

namespace Common\Domain\Service\User\Resource;

use Common\Domain\Entity\User\Resource;
use Common\Domain\Service\Support\Destroy as CommonDestroy;

/**
 * 资源删除.
 */
class Destroy
{
    use CommonDestroy;

    /**
     * 返回实体.
     */
    private function entity(): string
    {
        return Resource::class;
    }
}
