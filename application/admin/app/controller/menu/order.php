<?php declare(strict_types=1);
// (c) 2018 http://your.domain.com All rights reserved.
namespace admin\app\controller\menu;

use queryyetsimple\request;
use admin\app\controller\aaction;
use admin\domain\service\menu\order_failed;
use admin\domain\service\menu\order as service;

/**
 * 后台菜单排序更新
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.10.12
 * @version 1.0
 * @menu
 * @title 排序
 * @name
 * @path
 * @component
 * @icon
 */
class order extends aaction
{

    /**
     * 响应方法
     *
     * @param \admin\domain\service\admin_menu\order $oService
     * @return mixed
     */
    public function run(service $oService)
    {
        try {
            $strType = $this->type();
            $mixResult = $oService->run($this->id(), $strType);
            return [
                'message' => __('菜单%s成功', $this->messageType($strType))
            ];
        } catch (order_failed $oE) {
            return [
                'code' => 400,
                'message' => $oE->getMessage()
            ];
        }
    }

    /**
     * 排序类型
     *
     * @return string
     */
    protected function type()
    {
        return trim(request::all('type'));
    }

    /**
     * 排序作用 ID
     *
     * @return int
     */
    protected function id()
    {
        return intval(request::all('args\0'));
    }

    /**
     * 成功消息类型
     *
     * @param string $strType
     * @return string
     */
    protected function messageType($strType)
    {
        return ['top' => __('置顶'), 'up' => __('上移'), 'down' => __('下移')][$strType];
    }
}
