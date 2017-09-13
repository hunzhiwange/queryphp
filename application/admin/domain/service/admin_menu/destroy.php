<?php
namespace admin\domain\service\admin_menu;

use common\domain\model\admin_menu;
use admin\domain\service\admin_menu\exception\destroy_failed;

class destroy {

    protected $oMenu;

    public function __construct(admin_menu $oMenu){
        $this->oMenu = $oMenu;
    }

    public function run($nId){
        $this->checkChildren($nId);
        return $this->oMenu->destroy($nId);
    }

    protected function checkChildren($nId){
        if($this->hasChildren($nId))
            throw new destroy_failed('菜单包含子菜单，无法删除');
    }

    protected function hasChildren($nId){
        return $this->oMenu->where( 'pid',$nId )->getCount();
    }

}
