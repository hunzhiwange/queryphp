<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Resource;

use App\Domain\Dto\ParamsDto;
use App\Domain\Entity\User\Resource;
use App\Domain\Validate\User\Resource as ResourceValidate;
use Leevel\Validate\UniqueRule;

/**
 * 资源更新参数.
 */
class UpdateParams extends ParamsDto
{
    use BaseStoreUpdateParams;

    public int $id;

    protected string $validatorClass = ResourceValidate::class;

    protected string $validatorScene = 'update';

    /**
     * {@inheritDoc}
     */
    protected function validatorClassArgs(): array
    {
        $uniqueRule = UniqueRule::rule(
            Resource::class,
            exceptId: $this->id,
        );

        return [$uniqueRule];
    }
}
