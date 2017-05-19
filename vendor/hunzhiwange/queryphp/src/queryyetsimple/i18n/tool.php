<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
namespace queryyetsimple\i18n;

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

use queryyetsimple\exception\exceptions;
use queryyetsimple\filesystem\directory;
use queryyetsimple\helper\helper;

/**
 * 语言包工具类
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2016.11.25
 * @version 1.0
 */
class tool {
    
    /**
     * 保存数据到 JS 的缓存文件
     *
     * @param string|array $Files
     *            文件地址
     * @param string $CacheFile
     *            缓存目录
     * @param string $sI18nSet
     *            语言上下文环境
     * @author 小牛
     * @since 2016.11.27
     * @return array
     */
    public static function saveToJs($Files, $sCacheFile, $sI18nSet) {
        // 读取语言包数据
        if (is_string ( $Files )) {
            $Files [] = $Files;
        }
        $arrTexts = static::parsePoData_ ( $Files );
        
        $sDir = dirname ( $sCacheFile );
        if (! is_dir ( $sDir )) {
            directory::create ( $sDir );
        }
        // 防止空数据无法写入
        $arrTexts ['Query Yet Simple'] = 'Query Yet Simple';
        if (! file_put_contents ( $sCacheFile, "/* I18n Cache */\n;$(function(){\n    $.fn.queryphp('i18nPackage',\''.$sI18nSet.'\'," . json_encode ( $arrTexts, 256 ) . "); \n});" )) {
            exceptions::throwException ( sprintf ( 'Dir %s do not have permission.', $sCacheDir ) );
        }
        
        return $arrTexts;
    }
    
    /**
     * 保存数据到 PHP 的缓存文件
     *
     * @param string|array $Files
     *            文件地址
     * @param string $CacheFile
     *            缓存目录
     * @author 小牛
     * @since 2016.11.27
     * @return array
     */
    public static function saveToPhp($Files, $sCacheFile) {
        // 读取语言包数据
        if (is_string ( $Files )) {
            $Files [] = $Files;
        }
        $arrTexts = static::parsePoData_ ( $Files );
        
        $sDir = dirname ( $sCacheFile );
        if (! is_dir ( $sDir )) {
            directory::create ( $sDir );
        }
        // 防止空数据无法写入
        $arrTexts ['Query Yet Simple'] = 'Query Yet Simple';
        if (! file_put_contents ( $sCacheFile, "<?php\n /* I18n Cache */ \n return " . var_export ( $arrTexts, true ) . "\n?>" )) {
            exceptions::throwException ( sprintf ( 'Dir %s do not have permission.', $sDir ) );
        }
        
        return $arrTexts;
    }
    
    /**
     * 分析目录中的 PHP 和 JS 语言包包含的文件
     *
     * @param string|array $I18nDir
     *            文件地址
     * @author 小牛
     * @since 2016.11.27
     * @return array
     */
    public static function findPoFile($I18nDir) {
        if (is_string ( $I18nDir )) {
            $I18nDir = [ 
                    $I18nDir 
            ];
        }
        
        // 返回结果 PHP 和 JS 分别返回
        $arrFiles = [ 
                'js' => [ ],
                'php' => [ ] 
        ];
        $arrParams = [ 
                'return' => 'file',
                'filterext' => [ 
                        'mo' 
                ],
                'fullpath' => true 
        ];
        foreach ( $I18nDir as $sDir ) {
            if (! is_dir ( $sDir )) {
                continue;
            }
            if (is_dir ( $sDir . '/js' )) {
                $arrFiles ['js'] = array_merge ( $arrFiles ['js'], directory::lists ( $sDir . '/js', $arrParams ) );
            }
            if (is_dir ( $sDir . '/php' )) {
                $arrFiles ['php'] = array_merge ( $arrFiles ['php'], directory::lists ( $sDir . '/php', $arrParams ) );
            }
        }
        
        return $arrFiles;
    }
    
    /**
     * 分析 PO 文件语言包数据
     *
     * @param string|array $I18nFile
     *            文件地址
     * @author 小牛
     * @since 2016.11.25
     * @return array
     */
    private static function parsePoData_($I18nFile) {
        if (is_string ( $I18nFile )) {
            $I18nFile = [ 
                    $I18nFile 
            ];
        }
        $sContent = '';
        foreach ( $I18nFile as $sFile ) {
            if (! is_file ( $sFile )) {
                exceptions::throwException ( sprintf ( 'The i18n file < %s > is not exists!', $sFile ), 'queryyetsimple\event\exception' );
            }
            $sContent .= helper::escapeCharacter ( file_get_contents ( $sFile ) );
        }
        
        $arrResult = [ ];
        if (preg_match_all ( "/msgid \"(.*?)\"/i", $sContent, $arrSource ) && preg_match_all ( "/msgstr \"(.*?)\"/i", $sContent, $arrNew )) {
            foreach ( $arrSource [1] as $nKey => $sSource ) {
                $sSource = trim ( $sSource );
                if ($sSource) {
                    $sSource = helper::escapeCharacter ( $sSource, true );
                }
                
                if ($sSource) {
                    $sNew = trim ( $arrNew [1] [$nKey] );
                    if ($sNew) {
                        $sNew = helper::escapeCharacter ( $sNew, true );
                    } else {
                        $sNew = $sSource;
                    }
                    $arrResult [$sSource] = $sNew;
                }
            }
        }
        
        return $arrResult;
    }
}
