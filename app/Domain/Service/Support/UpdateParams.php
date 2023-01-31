<?php

declare(strict_types=1);

namespace App\Domain\Service\Support;

use App\Domain\Dto\ParamsDto;
use Leevel\Validate\UniqueRule;

/**
 * 通用更新参数.
 */
class UpdateParams extends ParamsDto
{
    protected string $validatorScene = 'update';

    protected string $entityClass = '';

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