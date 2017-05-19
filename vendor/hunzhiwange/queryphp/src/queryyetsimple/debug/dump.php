<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
namespace queryyetsimple\debug;

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

use Symfony\Component\VarDumper\Dumper\CliDumper;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;
use Symfony\Component\VarDumper\Cloner\VarCloner;

/**
 * 调试一个变量
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2017.04.05
 * @version 4.0
 */
class dump {
    
    /**
     * 调试一个变量
     *
     * @param mixed $mixValue            
     * @param boolean $booSimple            
     * @return void|string
     */
    public static function dump($mixValue, $booSimple = false) {
        static $objDump, $objVarCloner;
        if ($booSimple === false && class_exists ( CliDumper::class )) {
            if (! $objDump) {
                $objDump = ('cli' === PHP_SAPI ? new CliDumper () : new HtmlDumper ());
                $objVarCloner = new VarCloner ();
            }
            $objDump->dump ( $objVarCloner->cloneVar ( $mixValue ) );
        } else {
            $arrArgs = func_get_args ();
            array_shift ( $arrArgs );
            array_shift ( $arrArgs );
            array_unshift ( $arrArgs, $mixValue );
            return call_user_func_array ( [ 
                    'queryyetsimple\debug\dump',
                    'varDump' 
            ], $arrArgs );
        }
    }
    
    /**
     * 调试变量
     *
     * @param mixed $Var            
     * @param boolean $bEcho            
     * @return mixed
     */
    public static function varDump($mixVar, $bEcho = true) {
        ob_start ();
        var_dump ( $mixVar );
        $sOutput = ob_get_clean ();
        if (! extension_loaded ( 'xdebug' )) {
            $sOutput = preg_replace ( "/\]\=\>\n(\s+)/m", "] => ", $sOutput );
            $sOutput = 'cli' === PHP_SAPI ? $sOutput : '<pre>' . htmlspecialchars ( $sOutput, ENT_QUOTES ) . '</pre>';
        }
        
        if ($bEcho)
            echo $sOutput;
        else
            return $sOutput;
    }
}
