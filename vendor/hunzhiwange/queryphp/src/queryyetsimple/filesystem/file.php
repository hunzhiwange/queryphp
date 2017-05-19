<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
namespace queryyetsimple\filesystem;

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

use queryyetsimple\traits\dynamic\expansion as dynamic_expansion;
use queryyetsimple\exception\exceptions;

/**
 * 文件
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2017.04.05
 * @version 4.0
 */
class file {
    
    /**
     * 新建文件
     *
     * @param $sPath string            
     * @param $nMode=0766 int            
     * @return bool
     */
    static public function create($sPath, $nMode = 0766) {
        $sDir = dirname ( $sPath );
        
        if (is_file ( $sDir )) {
            exceptions::invalidArgumentException ();
        }
        
        if (! file_exists ( $sDir ) && directory::create ( $sDir )) {
            exceptions::runtimeException ();
        }
        
        if ($hFile = fopen ( $sPath, 'a' )) {
            chmod ( $sPath, $nMode );
            return fclose ( $hFile );
        } else {
            exceptions::runtimeException ();
        }
    }
    
    /**
     * 获取上传文件扩展名
     *
     * @param 文件名 $sFileName            
     * @param number $nCase
     *            格式化参数 0 默认，1 转为大小 ，转为大小
     * @return string
     */
    public static function getExtName($sFileName, $nCase = 0) {
        if (! preg_match ( '/\./', $sFileName )) {
            return '';
        }
        
        $sFileName = explode ( '.', $sFileName );
        $sFileName = end ( $sFileName );
        
        if ($nCase == 1) {
            return strtoupper ( $sFileName );
        } elseif ($nCase == 2) {
            return strtolower ( $sFileName );
        } else {
            return $sFileName;
        }
    }
}
