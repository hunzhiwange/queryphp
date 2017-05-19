<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
namespace queryyetsimple\console;

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

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use queryyetsimple\exception\exceptions;
use queryyetsimple\string\string;

/**
 * 命令行参数解析 <from lavarel>
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2017.04.26
 * @version 4.0
 */
class parser {
    
    /**
     * 将命令配置解析为数组
     *
     * @param string $strExpression            
     * @return array
     */
    public static function parse($strExpression) {
        if (trim ( $strExpression ) === '') {
            exceptions::invalidArgumentException ();
        }
        
        preg_match ( '/[^\s]+/', $strExpression, $arrMatches );
        
        if (isset ( $arrMatches [0] )) {
            $strName = $arrMatches [0];
        } else {
            exceptions::runtimeException ();
        }
        
        preg_match_all ( '/\{\s*(.*?)\s*\}/', $strExpression, $arrMatches );
        
        $arrTokens = isset ( $arrMatches [1] ) ? $arrMatches [1] : [ ];
        
        if (count ( $arrTokens )) {
            return array_merge ( [ 
                    $strName 
            ], static::parameters_ ( $arrTokens ) );
        }
        
        return [ 
                $strName,
                [ ],
                [ ] 
        ];
    }
    
    /**
     * 提取参数
     *
     * @param array $arrTokens            
     * @return array
     */
    private static function parameters_(array $arrTokens) {
        $arrArguments = $arrOptions = [ ];
        
        foreach ( $arrTokens as $strToken ) {
            if (! string::startsWith ( $strToken, '--' )) {
                $arrArguments [] = static::parseArgument_ ( $strToken );
            } else {
                $arrOptions [] = static::parseOption_ ( ltrim ( $strToken, '-' ) );
            }
        }
        
        return [ 
                $arrArguments,
                $arrOptions 
        ];
    }
    
    /**
     * 解析参数表达式
     *
     * @param string $strToken            
     * @return \Symfony\Component\Console\Input\InputArgument
     */
    private static function parseArgument_($strToken) {
        $strDescription = null;
        
        if (string::contains ( $strToken, ' : ' )) {
            list ( $strToken, $strDescription ) = explode ( ' : ', $strToken, 2 );
            $strToken = trim ( $strToken );
            $strDescription = trim ( $strDescription );
        }
        
        switch (true) {
            case string::endsWith ( $strToken, '?*' ) :
                return new InputArgument ( trim ( $strToken, '?*' ), InputArgument::IS_ARRAY, $strDescription );
            
            case string::endsWith ( $strToken, '*' ) :
                return new InputArgument ( trim ( $strToken, '*' ), InputArgument::IS_ARRAY | InputArgument::REQUIRED, $strDescription );
            
            case string::endsWith ( $strToken, '?' ) :
                return new InputArgument ( trim ( $strToken, '?' ), InputArgument::OPTIONAL, $strDescription );
            
            case preg_match ( '/(.+)\=(.+)/', $strToken, $arrMatches ) :
                return new InputArgument ( $arrMatches [1], InputArgument::OPTIONAL, $strDescription, $arrMatches [2] );
            
            default :
                return new InputArgument ( $strToken, InputArgument::REQUIRED, $strDescription );
        }
    }
    
    /**
     * 解析配置表达式
     *
     * @param string $strToken            
     * @return \Symfony\Component\Console\Input\InputOption
     */
    private static function parseOption_($strToken) {
        $strDescription = null;
        
        if (string::contains ( $strToken, ' : ' )) {
            list ( $strToken, $strDescription ) = explode ( ' : ', $strToken );
            $strToken = trim ( $strToken );
            $strDescription = trim ( $strDescription );
        }
        
        $strShortcut = null;
        $arrMatches = preg_split ( '/\s*\|\s*/', $strToken, 2 );
        
        if (isset ( $arrMatches [1] )) {
            $strShortcut = $arrMatches [0];
            $strToken = $arrMatches [1];
        }
        
        switch (true) {
            case string::endsWith ( $strToken, '=' ) :
                return new InputOption ( trim ( $strToken, '=' ), $strShortcut, InputOption::VALUE_OPTIONAL, $strDescription );
            
            case string::endsWith ( $strToken, '=*' ) :
                return new InputOption ( trim ( $strToken, '=*' ), $strShortcut, InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY, $strDescription );
            
            case preg_match ( '/(.+)\=(.+)/', $strToken, $arrMatches ) :
                return new InputOption ( $arrMatches [1], $strShortcut, InputOption::VALUE_OPTIONAL, $strDescription, $arrMatches [2] );
            
            default :
                return new InputOption ( $strToken, $strShortcut, InputOption::VALUE_NONE, $strDescription );
        }
    }
   
}
