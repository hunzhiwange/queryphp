<?php

declare(strict_types=1);

namespace App\Domain\Service\Base;

use App\Domain\Entity\Base\Option as OptionEntity;
use Leevel\Database\Ddd\UnitOfWork;

/**
 * 获取配置.
 */
class Options
{
    public function __construct(private UnitOfWork $w)
    {
    }

    public function handle(): array
    {
        $options = $this->w
            ->repository(OptionEntity::class)
            ->findAll();
        $result = $options->toArray();

        return $result ? array_column($result, 'value', 'name') : [];
    }
}
