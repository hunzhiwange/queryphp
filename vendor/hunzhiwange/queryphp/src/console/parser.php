<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
namespace Q\console;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

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
            exception::throws ( 'command is allowed to be empty', 'Q\console\exception' );
        }
        
        preg_match ( '/[^\s]+/', $strExpression, $arrMatches );
        
        if (isset ( $arrMatches [0] )) {
            $strName = $arrMatches [0];
        } else {
            exception::throws ( 'can not parse command', 'Q\console\exception' );
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
            if (! static::startsWith_ ( $strToken, '--' )) {
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
        
        if (static::contains_ ( $strToken, ' : ' )) {
            list ( $strToken, $strDescription ) = explode ( ' : ', $strToken, 2 );
            $strToken = trim ( $strToken );
            $strDescription = trim ( $strDescription );
        }
        
        switch (true) {
            case static::endsWith_ ( $strToken, '?*' ) :
                return new InputArgument ( trim ( $strToken, '?*' ), InputArgument::IS_ARRAY, $strDescription );
            
            case static::endsWith_ ( $strToken, '*' ) :
                return new InputArgument ( trim ( $strToken, '*' ), InputArgument::IS_ARRAY | InputArgument::REQUIRED, $strDescription );
            
            case static::endsWith_ ( $strToken, '?' ) :
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
        
        if (static::contains_ ( $strToken, ' : ' )) {
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
            case static::endsWith_ ( $strToken, '=' ) :
                return new InputOption ( trim ( $strToken, '=' ), $strShortcut, InputOption::VALUE_OPTIONAL, $strDescription );
            
            case static::endsWith_ ( $strToken, '=*' ) :
                return new InputOption ( trim ( $strToken, '=*' ), $strShortcut, InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY, $strDescription );
            
            case preg_match ( '/(.+)\=(.+)/', $strToken, $arrMatches ) :
                return new InputOption ( $arrMatches [1], $strShortcut, InputOption::VALUE_OPTIONAL, $strDescription, $arrMatches [2] );
            
            default :
                return new InputOption ( $strToken, $strShortcut, InputOption::VALUE_NONE, $strDescription );
        }
    }
    
    /**
     * 判断字符串中是否包含给定的字符开始
     *
     * @param string $strToSearched            
     * @param string $strSearch            
     * @return bool
     */
    private static function startsWith_($strToSearched, $strSearch) {
        if ($strSearch != '' && strpos ( $strToSearched, $strSearch ) === 0) {
            return true;
        }
        return false;
    }
    
    /**
     * 判断字符串中是否包含给定的字符结尾
     *
     * @param string $strToSearched            
     * @param string $strSearch            
     * @return bool
     */
    private static function endsWith_($strToSearched, $strSearch) {
        if (( string ) $strSearch === substr ( $strToSearched, - strlen ( $strSearch ) )) {
            return true;
        }
        return false;
    }
    
    /**
     * 判断字符串中是否包含给定的字符串集合
     *
     * @param string $strToSearched            
     * @param string $strSearch            
     * @return bool
     */
    private static function contains_($strToSearched, $strSearch) {
        if ($strSearch != '' && strpos ( $strToSearched, $strSearch ) !== false) {
            return true;
        }
        return false;
    }
}
