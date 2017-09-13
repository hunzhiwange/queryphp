<?php
namespace admin\domain\service\common_option;

use common\domain\model\common_option;

class get {

    protected $oOption;

    public function __construct(common_option $oOption){
        $this->oOption = $oOption;
    }

    public function run(){
        $arr = [];
        foreach ($this->oOption->setColumns('name,value')->getAll() as $arrVal) {
            $arr[$arrVal['name']] = $arrVal['value'];
        }
        return $arr;
    }

}
