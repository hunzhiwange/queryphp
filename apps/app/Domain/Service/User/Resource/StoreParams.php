<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Resource;

use App\Domain\Dto\ParamsDto;
use App\Domain\Entity\User\Resource;
use App\Domain\Validate\User\Resource as ResourceValidate;
use Leevel\Validate\UniqueRule;

/**
 * 资源保存参数.
 */
class StoreParams extends ParamsDto
{
    use BaseStoreUpdateParams;

    protected string $validatorClass = ResourceValidate::class;

    protected string $validatorScene = 'store';

    /**
     * {@inheritDoc}
     */
    protected function validatorClassArgs(): array
    {
        $uniqueRule = UniqueRule::rule(
            Resource::class,
        );

        return [$uniqueRule];
    }
}
