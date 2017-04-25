<?php
/*
 * [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
 * ©2010-2017 http://queryphp.com All rights reserved.
 * 
 * ##########################################################
 * #   ____                          ______  _   _ ______   #
 * #  /     \       ___  _ __  _   _ | ___ \| | | || ___ \  # 
 * # |   (  ||(_)| / _ \| '__|| | | || |_/ /| |_| || |_/ /  #
 * #  \____/ |___||  __/| |   | |_| ||  __/ |  _  ||  __/   #
 * #       \__   | \___ |_|    \__  || |    | | | || |      #
 * #     Query Yet Simple      __/  |\_|    |_| |_|\_|      #
 * #                          |___ /  Since 2010.10.03      #
 * ##########################################################
 * 
 * @author Xiangmin Liu<635750556@qq.com>
 * @version $$
 * @date 2017.04.13
 * @since 4.0
 */
namespace Q\support;

/**
 * 服务提供者
 *
 * @author Xiangmin Liu
 */
abstract class provider {
    
    /**
     * 应用程序实例
     *
     * @var Q\mvc\project
     */
    protected $objProject;
    
    /**
     * 创建一个服务容器提供者实例
     *
     * @param Q\mvc\project $objProject            
     * @return void
     */
    public function __construct($objProject) {
        $this->objProject = $objProject;
    }
    
    /**
     * 返回 project
     *
     * @return Q\mvc\project
     */
    public function project() {
        return $this->objProject;
    }
    
    /**
     * 注册一个提供者
     *
     * @return void
     */
    abstract public function register();
}
