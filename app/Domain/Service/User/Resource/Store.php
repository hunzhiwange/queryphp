<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Resource;

use App\Domain\Entity\User\Resource;
use App\Domain\Service\Support\Store as CommonStore;

/**
 * 资源保存.
 */
class Store
{
    use CommonStore;

    protected string $entityClass = Resource::class;
}
