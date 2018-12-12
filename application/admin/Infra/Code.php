<?php

declare(strict_types=1);

/*
 * This file is part of the forcodepoem package.
 *
 * The PHP Application Created By Code Poem. <Query Yet Simple>
 * (c) 2018-2099 http://forcodepoem.com All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Admin\Infra;

use Leevel\Cache;

/**
 * 验证码存储.
 *
 * @author Xiangmin Liu <635750556@qq.com>
 *
 * @since 2018.11.18
 *
 * @version 1.0
 */
class Code
{
    /**
     * 设置验证码
     *
     * @param string $id
     * @param string $code
     */
    public function set(string $id, string $code)
    {
        Cache::set('code_'.$id, $code);
    }

    /**
     * 获取验证码
     *
     * @param string $id
     *
     * @return string
     */
    public function get($id): string
    {
        return Cache::get('code_'.$id);
    }
}
