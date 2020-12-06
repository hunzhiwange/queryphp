<?php

declare(strict_types=1);

namespace Common\Domain\Service\Base;

use Common\Domain\Entity\Base\Option as Options;
use Leevel\Database\Ddd\UnitOfWork;

/**
 * 获取配置.
 */
class GetOption
{
    public function __construct(private UnitOfWork $w)
    {
    }

    public function handle(): array
    {
        $options = $this->w
            ->repository(Options::class)
            ->findAll();
        $result = $options->toArray();

        return $result ? array_column($result, 'value', 'name') : [];
    }
}
