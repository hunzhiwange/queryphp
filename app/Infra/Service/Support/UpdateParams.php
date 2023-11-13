<?php

declare(strict_types=1);

namespace App\Infra\Service\Support;

use App\Infra\Dto\ParamsDto;
use Leevel\Validate\UniqueRule;

/**
 * 通用更新参数.
 */
class UpdateParams extends ParamsDto
{
    public int $id = 0;

    public string $validatorScene = 'update';

    /**
     * {@inheritDoc}
     */
    protected function validatorArgs(): array
    {
        $primaryId = $this->entityClass::ID;

        $uniqueRule = UniqueRule::rule(
            $this->entityClass,
            exceptId: $this->{$primaryId},
        );

        return [$uniqueRule];
    }
}
