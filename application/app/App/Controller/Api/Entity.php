<?php

declare(strict_types=1);

namespace App\App\Controller\Api;

use Common\Domain\Entity\Demo\Test;

/**
 * 实体使用.
 *
 * @codeCoverageIgnore
 */
class Entity
{
    /**
     * 默认方法.
     */
    public function handle(): array
    {
        return ['count' => Test::select()->findCount()];
    }
}
