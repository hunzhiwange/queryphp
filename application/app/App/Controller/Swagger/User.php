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

namespace App\App\Controller\Swagger;

use Leevel;

/**
 * 用户文档测试.
 *
 * - 文档太多加载速度就很慢，可以针对不同的服务加入不同的路径
 * - 访问地址 http://127.0.0.1:9527/apis/#/swagger/user
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2019.07.29
 *
 * @version 1.0
 * @codeCoverageIgnore
 */
class User extends Index
{
    /**
     * 扫描路径.
     *
     * @return array
     */
    protected function path(): array
    {
        return [
            Leevel::appPath('app/App/Controller/Petstore/User.php'),
        ];
    }
}
