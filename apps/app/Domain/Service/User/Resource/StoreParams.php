<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Resource;

use App\Domain\Entity\User\Resource;
use App\Domain\Validate\User\Resource as ResourceValidate;
use App\Domain\Service\Support\StoreParams as CommonStoreParams;

/**
 * 资源保存参数.
 */
class StoreParams extends CommonStoreParams
{
    use BaseStoreUpdateParams;

    protected string $validatorClass = ResourceValidate::class;

    protected string $entityClass = Resource::class;
}
