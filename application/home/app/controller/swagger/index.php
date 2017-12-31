<?php
// (c) 2018 http://your.domain.com All rights reserved.
namespace home\app\controller\swagger;

use Exception;
use queryyetsimple\mvc\action;

/**
 * api 文档入口
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.10.12
 * @version 1.0
 */
class index extends action
{

    /**
     * API 生成 
     *
     * @SWG\Swagger(
     *   @SWG\Info(
     *     title="QueryPHP API Doccument",
     *     version="1.0.0"
     *   )
     * )
     */
    public function run()
    {
        $oSwagger = \Swagger\scan(path_application('home/app/controller/'));

        $strApiJson = $oSwagger->__toString();
        $strApiPath = path('www/api/swagger.json');

        if(! file_put_contents($strApiPath, $strApiJson)) {
            throw new Exception(sprintf('Dir %s is not writeable', dirname($strApiPath)));
        }

        return $strApiJson;
    }
}
