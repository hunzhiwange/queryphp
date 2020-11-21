<?php

declare(strict_types=1);

/*
 * This file is part of the your app package.
 *
 * The PHP Application For Code Poem For You.
 * (c) 2018-2099 http://yourdomian.com All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Common\Domain\Service\User\User;

use Common\Domain\Entity\User\User;

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
    public function handleMulti(iterable $data): array
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
