<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Resource;

use App\Domain\Entity\User\Resource;
use App\Domain\Service\Support\UpdateParams as CommonUpdateParams;
use App\Domain\Validate\User\Resource as ResourceValidate;

/**
 * 资源更新参数.
 */
class UpdateParams extends CommonUpdateParams
{
    use BaseStoreUpdateParams;

    public int $id;

    protected string $validatorClass = ResourceValidate::class;

    protected string $entityClass = Resource::class;
}
