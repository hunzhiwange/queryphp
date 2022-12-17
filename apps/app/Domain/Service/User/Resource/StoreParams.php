<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Resource;

use App\Domain\Entity\User\Resource;
use App\Domain\Validate\User\Resource as ResourceValidate;
use App\Domain\Validate\ValidateParams;
use Leevel\Support\Dto;
use Leevel\Validate\UniqueRule;

/**
 * 资源保存参数.
 */
class StoreParams extends Dto
{
    use BaseStoreUpdateParams;
    use ValidateParams;

    /**
     * 校验基本参数.
     */
    public function validate(): void
    {
        $uniqueRule = UniqueRule::rule(
            Resource::class,
        );

        $this->baseValidate(
            new ResourceValidate($uniqueRule),
            'store',
        );
    }
}
