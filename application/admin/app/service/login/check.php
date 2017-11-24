<?php
// (c) 2018 http://your.domain.com All rights reserved.
namespace admin\app\service\login;

use queryyetsimple\http\request;
use queryyetsimple\support\tree;
use admin\domain\entity\admin_menu;
use queryyetsimple\bootstrap\auth\login;

/**
 * 验证登录
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.11.23
 * @version 1.0
 */
class check
{
    use login;

    /**
     * HTTP 请求
     *
     * @var \queryyetsimple\http\request
     */
    protected $oRequest;

    /**
     * 构造函数
     *
     * @param \queryyetsimple\http\request $oRequest
     * @return void
     */
    public function __construct(request $oRequest)
    {
        $this->oRequest = $oRequest;
    }

    /**
     * 响应方法
     *
     * @param array $arrData
     * @param string $strCode
     * @return array
     */
    public function run(array $arrData, $strCode)
    {
        if (!$this->checkCode($arrData['seccode'], $strCode)) {
            return ['message' => '验证码错误', 'code' => 400];
        }

        // 登录失败
        $arrLogin = $this->checkLogin($this->oRequest);
        if (isset($arrLogin['code'])) {
            return $arrLogin;
        }

        // 登录成功
        $arrData = [
            'message' => '登录成功',
            'authKey' => $arrLogin['api_token'],
            'userInfo' => $arrLogin['user']
        ];
        $arrData['menusList'] = $this->getMenu();
        $arrData['authList'] = $this->getAuth();

        return $arrData;
    }

    /**
     * 获取权限
     *
     * @return array
     */
    protected function getAuth()
    {
        return [];
    }

    /**
     * 取得菜单
     *
     * @return array
     */
    protected function getMenu()
    {
        $arrList = admin_menu::getAll();
        $arrNode = [];
        foreach ($arrList as $arr) {
            $arrNode[] = [
                $arr['id'],
                $arr['pid'],
                $arr->toArray()
            ];
        }

        $oTree = new tree($arrNode);

        return $oTree->toArray(function ($arrItem, $oTree) {
            $arrNew = $arrItem['data'];
            return $arrNew;
        }, ['children'=>'child']);
    }

    /**
     * 对比验证码
     *
     * @param string $strInputCode
     * @param string $strCode
     * @return boolean
     */
    protected function checkCode($strInputCode, $strCode)
    {
        return strtoupper($strInputCode) == strtoupper($strCode);
    }
}
