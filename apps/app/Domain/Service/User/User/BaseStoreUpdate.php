<?php

declare(strict_types=1);

namespace App\Domain\Service\User\User;

use App\Domain\Entity\User\User;

trait BaseStoreUpdate
{
    /**
     * 准备数据.
     */
    private function prepareData(User $user): array
    {
        return (new PrepareForUser())->handle($user);
    }
}
