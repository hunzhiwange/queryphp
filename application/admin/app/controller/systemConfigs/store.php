<?php
// (c) 2018 http://your.domain.com All rights reserved.
namespace admin\app\controller\systemConfigs;

use queryyetsimple\request;
use admin\app\controller\aaction;
use common\domain\service\common_option\update as service;

/**
 * 后台配置信息更新保存
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.10.23
 * @version 1.0
 */
class store extends aaction
{

    /**
     * 响应方法
     *
     * @param \common\domain\service\common_option\update $oService
     * @return mixed
     */
    public function run(service $oService)
    {
        $mixResult = $oService->run($this->data());
        return [
            'message' => '配置更新成功'
        ];
    }

    /**
     * POST 数据
     *
     * @return array
     */
    protected function data()
    {
        return request::alls([
            'SYSTEM_NAME|trim',
            'IDENTIFYING_CODE|intval',
            'LOGO_TYPE|intval',
            'LOGIN_SESSION_VALID|intval',
            'SYSTEM_LOGO|trim'
        ]);
    }
}
