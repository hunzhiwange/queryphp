<?php
// (c) 2018 http://your.domain.com All rights reserved.
namespace admin\app\controller\menu;

use queryyetsimple\request;
use admin\app\controller\aaction;
use admin\app\service\menu\enable_failed;
use admin\app\service\menu\enable as service;

/**
 * 后台菜单状态更新
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.10.12
 * @version 1.0
 * @menu
 * @title 启用禁用
 * @name
 * @path
 * @component
 * @icon
 */
class enable extends aaction
{

    /**
     * 响应方法
     *
     * @param \admin\app\service\menu\enable $oService
     * @return mixed
     */
    public function run(service $oService)
    {
        try {
            $strStatus = $this->status();
            $mixResult = $oService->run($this->id(), $strStatus);
            return [
                'message' => __('菜单状态%s成功', $this->messageType($strStatus))
            ];
        } catch (update_failed $oE) {
            return [
                'code' => 400,
                'message' => $oE->getMessage()
            ];
        }
    }

    /**
     * 启用禁用状态
     *
     * @return string
     */
    protected function status()
    {
        return trim(request::all('status'));
    }

    /**
     * ID 数据
     *
     * @return int
     */
    protected function id()
    {
        return request::all('args\0');
    }

    /**
     * 成功消息类型
     *
     * @param string $strType
     * @return string
     */
    protected function messageType($strType)
    {
        return ['disable' => __('禁用'), 'enable' => __('启用')][$strType];
    }
}
