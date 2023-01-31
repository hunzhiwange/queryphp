<?php

declare(strict_types=1);

namespace App\Domain\Service\Support;

use App\Domain\Dto\ParamsDto;
use Leevel\Validate\UniqueRule;

/**
 * 通用保存参数.
 */
class StoreParams extends ParamsDto
{
    protected string $validatorScene = 'store';

    protected string $entityClass = '';

    /**
     * {@inheritDoc}
     */
    protected function validatorArgs(): array
    {
        $uniqueRule = UniqueRule::rule(
            $this->entityClass,
        );

        return [$uniqueRule];
    }
}
