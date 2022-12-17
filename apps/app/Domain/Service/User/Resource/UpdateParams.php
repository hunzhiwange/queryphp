<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Resource;

use App\Domain\Entity\User\Resource;
use App\Domain\Validate\User\Resource as ResourceValidate;
use Leevel\Support\Dto;
use Leevel\Validate\UniqueRule;

/**
 * 资源更新参数.
 */
class UpdateParams extends Dto
{
    use BaseStoreUpdateParams;

    public int $id;

    /**
     * 校验基本参数.
     */
    public function validate(): void
    {
        $uniqueRule = UniqueRule::rule(
            Resource::class,
            exceptId:$this->id,
        );

        $this->baseValidate(
            new ResourceValidate($uniqueRule),
            'update',
        );
    }
}
