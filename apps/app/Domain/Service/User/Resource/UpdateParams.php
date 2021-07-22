<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Resource;

use Leevel\Support\Dto;

/**
 * 资源更新参数.
 */
class UpdateParams extends Dto
{
    use BaseStoreUpdateParams;

    public int $id;
}
