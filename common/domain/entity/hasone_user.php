<?php
namespace common\domain\entity;

use queryyetsimple\mvc\model;

class  hasone_user extends model {
    
    /**
     * 获取关联到用户的手机
     */
    public function idcard()
    {
        return $this->hasOne('common\domain\entity\hasone_idcard','idcard_number','idcard_number')->setColumns('idcard_number,idcard_address');
    } 

   /**
     * 获取关联到用户的手机
     */
    public function comment()
    {
        return $this->hasMany('common\domain\entity\hasmany_comment'/*,'idcard_number','idcard_number'*/);
    } 

       /**
     * 获取关联到用户的手机
     */
    public function role()
    {
        return $this->manyMany('common\domain\entity\many_role'/*, 'common\domain\entity\hasone_user_many_role'*//*, 'user_id', 'role_id','id','id'*/)->middleCondition(function($objMiddleSelect){
            //print_r($objMiddleSelect);
           // $objMiddleSelect->where('many_role_id',3);
        });
    } 

}
