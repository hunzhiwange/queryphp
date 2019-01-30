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

namespace Common\Domain\Service\User;

use Common\Domain\Entity\User;

/**
 * 准备用户基础数据.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2019.01.15
 *
 * @version 1.0
 */
class PrepareForUser
{
    /**
     * 响应方法.
     *
     * @param \Common\Domain\Entity\User $user
     *
     * @return array
     */
    public function handle(User $user): array
    {
        return $this->prepareUser($user);
    }

    /**
     * 准备用户数据.
     *
     * @param \Common\Domain\Entity\User $user
     *
     * @return array
     */
    protected function prepareUser(User &$user): array
    {
        $tmp = $user->toArray();
        $tmp['role'] = $user->role->toArray();

        return $tmp;
    }
}
