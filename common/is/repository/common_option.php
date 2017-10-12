<?php
// ©2017 http://your.domain.com All rights reserved.
namespace common\is\repository;

use common\domain\entity\common_option as aggregate;
use common\domain\repository\common_option as repository;

/**
 * 公共配置（聚合根）实现
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.10.12
 * @version 1.0
 */
class common_option implements repository {
    
    /**
     * 后台菜单聚合根
     *
     * @var \common\domain\entity\common_option
     */
    protected $oAggregate;
    
    /**
     * 构造函数
     *
     * @param \common\domain\entity\common_option $oAggregate            
     * @return void
     */
    public function __construct(aggregate $oAggregate) {
        $this->oAggregate = $oAggregate;
    }
    
    /**
     * 取得所有记录
     *
     * @return \queryyetsimple\support\collection
     */
    public function all() {
        return $this->oAggregate->getAll ();
    }
}
