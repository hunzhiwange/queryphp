<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Resource;

use Closure;
use App\Domain\Entity\User\Resource;
use App\Domain\Service\Support\Read;
use App\Domain\Service\User\Resource\ResourcesParams;
use Leevel\Database\Ddd\Select;
use Leevel\Database\Ddd\UnitOfWork;

/**
 * 资源列表.
 */
class Resources
{
    use Read;

    public function __construct(private UnitOfWork $w)
    {
    }

    public function handle(ResourcesParams $params): array
    {
        $repository = $this->w->repository(Resource::class);

        return $this->findPage($params, $repository);
    }

    private function prepareItem(Resource $user): array
    {
        return $user->toArray();
    }

    /**
     * 查询条件.
     */
    private function condition(ResourcesParams $params): Closure
    {
        return function (Select $select) use ($params) {
            $this->spec($select, $params);
        };
    }
}
