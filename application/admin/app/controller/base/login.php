<?php
// (c) 2018 http://your.domain.com All rights reserved.
namespace admin\app\controller\base;

use queryyetsimple\mvc\action;
use queryyetsimple\bootstrap\auth\login as auth_login_api;
use queryyetsimple\http\request;
use queryyetsimple\support\tree;
use admin\domain\entity\admin_menu;
use queryyetsimple\option;
use queryyetsimple\response;
use queryyetsimple\auth;

class login extends action
{
    use auth_login_api;
    public function run(request $oRequest)
    {
        $oRequest->setPost(option::get('var_ajax'), true);

        $mixLogin = $this->checkLogin($oRequest);
        if ($mixLogin instanceof response) {
            return $mixLogin;
        }

        $arrData = [
            'authKey' => $mixLogin['api_token'],
            'userInfo' => $mixLogin['user'],
            'rememberKey' => $mixLogin['remember_key']
        ];

        $arrData['menusList'] = $this->getMenu();
        $arrData['authList'] = $this->getAuth();

        return $arrData;
    }
    public function getAuth()
    {
    }
    public function getMenu()
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
        // print_r($oTree);
        return $oTree->toArray(function ($arrItem, $oTree) {
            $arrNew = $arrItem['data'];
            return $arrNew;
        }, ['children'=>'child']);
    }
}
