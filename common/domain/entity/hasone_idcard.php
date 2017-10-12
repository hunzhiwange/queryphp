<?php
namespace common\domain\entity;

use queryyetsimple\mvc\model;

class  hasone_idcard extends model {
    
   /**
     * 获取关联到用户的手机
     */
    public function user()
    {
        return $this->belongsTo('common\domain\entity\hasone_user','idcard_number','idcard_number');
    } 

}
