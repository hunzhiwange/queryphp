<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Resource;

use App\Domain\Entity\User\Resource;
use App\Domain\Service\Support\Read;

/**
 * 资源列表.
 */
class Resources
{
    use Read;

    public function handle(ResourcesParams $params): array
    {
        return $this->findLists($params, Resource::class);
    }
}
