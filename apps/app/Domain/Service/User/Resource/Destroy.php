<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Resource;

use App\Domain\Entity\User\Resource;
use App\Domain\Service\Support\Destroy as CommonDestroy;

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
