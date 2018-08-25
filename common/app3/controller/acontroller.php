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

namespace common\app\controller;

use queryyetsimple\mvc\controller;
use queryyetsimple\request;

/**
 * 基础控制器.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.10.12
 *
 * @version 1.0
 */
abstract class acontroller extends controller
{
    /**
     * 构造函数.
     */
    public function __construct()
    {
        // header('Access-Control-Allow-Origin: '.(isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN']: ''));
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId');

        if (request::isOptions()) {
            exit('cross-domain options validate');
        }
    }

    /**
     * IOC 容器调用回调实现自定义业务实例方法依赖注入.
     *
     * @param calable $calClass
     * @param array   $arrArgs
     *
     * @return mixed
     */
    public function call($calClass, array $arrArgs = [])
    {
        return $this->container()->call($calClass, $arrArgs);
    }

    /**
     * 返回 IOC 容器.
     *
     * @return \queryyetsimple\support\icontainer
     */
    public function container()
    {
        return app();
    }
}
