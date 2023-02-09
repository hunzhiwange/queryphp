<?php

declare(strict_types=1);

namespace App\Domain\Service\User\User;

use App\Domain\Entity\User\User;

/**
 * 准备用户基础数据.
 */
class PrepareForUser
{
    public function handle(User $user): array
    {
        return $this->prepareUser($user);
    }

    /**
     * 批量处理.
     */
    public function handleMulti(iterable $data): array // @phpstan-ignore-line
    {
        $result = [];
        foreach ($data as $v) {
            $result[] = $this->handle($v);
        }

        return $result;
    }

    /**
     * 准备用户数据.
     */
    private function prepareUser(User &$user): array
    {
        $tmp = $user->toArray();
        $tmp['role'] = $user->role->toArray();

        return $tmp;
    }
}
