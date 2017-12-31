<?php
// (c) 2018 http://your.domain.com All rights reserved.
namespace home\app\controller;

use queryyetsimple\mvc\controller;

/**
 * swagger 控制器
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.12.31
 * @version 1.0
 */
class swagger extends controller
{

    /**
     * 假设是项目中的一个API
     *
     * @SWG\Get(path="/swagger/my-data",
     *   tags={"project"},
     *   summary="拿一些神秘的数据",
     *   description="请求该接口需要先登录。",
     *   operationId="getMyData",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="formData",
     *     name="reason",
     *     type="string",
     *     description="拿数据的理由",
     *     required=true,
     *   ),
     *   @SWG\Response(response="default", description="操作成功")
     * )
     */
    public function getMyData()
    {

    }
}
