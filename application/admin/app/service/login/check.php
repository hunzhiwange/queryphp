<?php
// (c) 2018 http://your.domain.com All rights reserved.
namespace admin\app\service\login;

use queryyetsimple\http\request;
use queryyetsimple\support\tree;
use admin\domain\entity\admin_menu;
use queryyetsimple\bootstrap\auth\login;
use admin\is\repository\admin_menu as repository;

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
     * 后台菜单仓储
     *
     * @var \admin\is\repository\admin_menu
     */
    protected $oRepository;

    /**
     * 构造函数
     *
     * @param \queryyetsimple\http\request $oRequest
     * @param \admin\is\repository\admin_menu $oRepository
     * @return void
     */
    public function __construct(request $oRequest, repository $oRepository)
    {
        $this->oRequest = $oRequest;
        $this->oRepository = $oRepository;
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
        $arrList = $this->oRepository->all(function($objSelect){
            $objSelect->

            where('status', 'enable')->

            where('app', 'admin')->

            where('level', '2')->

            where('button', 'F');
        });

        $arrNode = [];
        foreach ($arrList as $arr) {
            $arrNode[] = [
                $arr['id'],
                $arr['pid'],
                $this->formatData($arr->toArray())
            ];
        }

        $oTree = new tree($arrNode);
        return $oTree->toArray(function ($arrItem, $oTree) {
            return $arrItem['data'];
        });
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

    /**
     * 格式化菜单
     *
     * @param array $arrData
     * @return array
     */
    protected function formatData(array $arrData)
    {
        return [
            'title' => $arrData['title'],
            'name' => $arrData['name'],
            'path' => $arrData['path'],
            'component' => $arrData['component'],
            'icon' => $arrData['icon']
        ];
    }
}
