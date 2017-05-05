<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
namespace Q\debug;

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

use Q\traits\dynamic\expansion as dynamic_expansion;

/**
 * 调试
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2017.04.05
 * @version 4.0
 */
class debug {
    
    use dynamic_expansion;
    
    /**
     * 调试工具
     *
     * @param mixed $Var            
     * @param boolean $bEcho            
     * @param string $sLabel            
     * @param boolean $bStrict            
     * @return mixed
     */
    public static function dump($mixVar, $bEcho = true, $sLabel = null, $bStrict = true) {
        $SLabel = ($sLabel === null) ? '' : rtrim ( $sLabel ) . ' ';
        if (! $bStrict) {
            if (ini_get ( 'html_errors' )) {
                $sOutput = print_r ( $mixVar, true );
                $sOutput = "<pre>" . $sLabel . htmlspecialchars ( $sOutput, ENT_QUOTES ) . "</pre>";
            } else {
                $sOutput = $sLabel . " : " . print_r ( $mixVar, true );
            }
        } else {
            ob_start ();
            var_dump ( $mixVar );
            $sOutput = ob_get_clean ();
            if (! extension_loaded ( 'xdebug' )) {
                $sOutput = preg_replace ( "/\]\=\>\n(\s+)/m", "] => ", $sOutput );
                $sOutput = '<pre>' . $sLabel . (\Q::isCli () ? $sOutput : htmlspecialchars ( $sOutput, ENT_QUOTES )) . '</pre>';
            }
        }
        
        if ($bEcho) {
            echo $sOutput;
            return null;
        } else {
            return $sOutput;
        }
    }
}
