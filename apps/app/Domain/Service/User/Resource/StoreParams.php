<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Resource;

use Leevel\Support\Dto;

/**
 * 资源保存参数.
 */
class StoreParams extends Dto
{
    use BaseStoreUpdateParams;
}
