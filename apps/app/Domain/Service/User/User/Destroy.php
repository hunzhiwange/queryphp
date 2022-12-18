<?php

declare(strict_types=1);

namespace App\Domain\Service\User\User;

use App\Domain\Entity\User\User;
use App\Domain\Service\Support\Destroy as CommonDestroy;

/**
 * 用户删除.
 */
class Destroy
{
    use CommonDestroy;

    protected string $entityClass = User::class;
}
