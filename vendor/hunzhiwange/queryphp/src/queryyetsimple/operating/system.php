<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
namespace queryyetsimple\operating;

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
 * 操作系统类
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2017.05.05
 * @version 1.0
 */
class system {
    
    /**
     * 是否为 window 平台
     *
     * @return boolean
     */
    public static function isWindows() {
        return DIRECTORY_SEPARATOR == '\\' ? true : false;
    }
    
    /**
     * 是否为 Linux 平台
     *
     * @return boolean
     */
    static public function isLinux() {
        return PHP_OS === 'Linux';
    }
    
    /**
     * 是否为 mac 平台
     *
     * @return boolean
     */
    public static function isMac() {
        return strstr ( PHP_OS, 'Darwin' ) ? true : false;
    }
    
    /**
     * 返回操作系统名称
     *
     * @return string
     */
    public static function osName() {
        return PHP_OS;
    }
    
    /**
     * 当前操作系统换行符
     *
     * @return string
     */
    public static function osNewline() {
        return PHP_EOL;
    }
}
