<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
namespace queryyetsimple\session\interfaces;

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

/**
 * session 接口
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2017.04.11
 * @version 1.0
 */
interface session {
    
    /**
     * 设置 session
     *
     * @param string $sName            
     * @param mxied $mixValue            
     * @param boolean $bPrefix            
     * @return void
     */
    public function set($sName, $mixValue, $bPrefix = true);
    
    /**
     * 取回 session
     *
     * @param string $sName            
     * @param boolean $bPrefix            
     * @return mxied
     */
    public function get($sName, $bPrefix = true);
    
    /**
     * 删除 session
     *
     * @param string $sName            
     * @param boolean $bPrefix            
     * @return bool
     */
    public function delete($sName, $bPrefix = true);
    
    /**
     * 是否存在 session
     *
     * @param string $sName            
     * @param boolean $bPrefix            
     */
    public function has($sName, $bPrefix = true);
    
    /**
     * 删除 session
     *
     * @param boolean $bOnlyDeletePrefix            
     * @return int
     */
    public function clear($bOnlyDeletePrefix = true);
    
    /**
     * 暂停 session
     *
     * @return void
     */
    public function pause();
    
    /**
     * 终止会话
     *
     * @return bool
     */
    public function destroy();
}
