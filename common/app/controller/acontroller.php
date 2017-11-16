<?php
// (c) 2018 http://your.domain.com All rights reserved.
namespace common\app\controller;

use queryyetsimple\request;
use queryyetsimple\mvc\controller;

/**
 * 基础控制器
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.10.12
 * @version 1.0
 */
abstract class acontroller extends controller
{

    /**
     * 构造函数
     *
     * @return  void
     */
    public function __construct()
    {
        // header('Access-Control-Allow-Origin: '.(isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN']: ''));
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId");

        if (request::isOptions()) {
            exit('cross-domain options validate');
        }
    }

    /**
     * IOC 容器调用回调实现自定义业务实例方法依赖注入
     *
     * @param  calable $calClass
     * @param  array  $arrArgs
     * @return mixed
     */
    public function call($calClass, array $arrArgs = [])
    {
        return $this->container()->call($calClass, $arrArgs);
    }

    /**
     * 返回 IOC 容器
     *
     * @return \queryyetsimple\support\icontainer
     */
    public function container()
    {
        return app();
    }
}
