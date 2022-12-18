<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Resource;

use App\Domain\Entity\User\Resource;
use App\Domain\Service\Support\Update as CommonUpdate;

/**
 * 资源更新.
 */
class Update
{
    use CommonUpdate;

    protected string $entityClass = Resource::class;
}
