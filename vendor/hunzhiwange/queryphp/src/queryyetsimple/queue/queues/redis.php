<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
namespace queryyetsimple\queue\queues;

<<<queryphp
##########################################################
#   ____                          ______  _   _ ______   #
#  /     \       ___  _ __  _   _ | ___ \| | | || ___ \  #
# |   (  ||(_)| / _ \| '__|| | | || |_/ /| |_| || |_/ /  #
#  \____/ |___||  __/| |   | |_| ||  __/ |  _  ||  __/   #
#       \__   | \___ |_|    \__  || |    | | | || |      #
#     Query Yet Simple      __/  |\_|    |_| |_|\_|      #
#                          |___ /  Since 2010.10.03      #
##########################################################
queryphp;

use queryyetsimple\queue\queue;
use PHPQueue\Base;

/**
 * redis 消息队列
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2017.05.11
 * @version 1.0
 */
class redis extends queue {
    
    /**
     * 队列连接
     *
     * @var string
     */
    protected $strConnect = 'redis';
    
    /**
     * 连接配置
     *
     * @var array
     */
    protected $arrSourceConfig = [ 
            'servers' => [ 
                    '127.0.0.1:6379' 
            ],
            'redis_options' => [ ] 
    ];
    
    /**
     * 队列执行者
     *
     * @var string
     */
    protected $strQueueWorker = 'redis';
    
    /**
     * 构造函数
     *
     * @return void
     */
    public function __construct() {
        parent::__construct ();
        $this->resDataSource = Base::backendFactory ( 'Predis', $this->arrSourceConfig );
    }
    
    /**
     * 取得消息队列长度
     *
     * @return int
     */
    public function getQueueSize() {
    }
}