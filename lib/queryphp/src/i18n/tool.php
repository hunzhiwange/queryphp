<?php
/*
 * [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
 * ©2010-2017 http://queryphp.com All rights reserved.
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @version $$
 * @date 2016.11.25
 * @since 1.0
 */
namespace Q\i18n;

use Q;

/**
 * 语言包工具类
 *
 * @author Xiangmin Liu
 */
class tool {
    
    /**
     * 保存数据到 JS 的缓存文件
     *
     * @param
     *            string | array $Files 文件地址
     * @param string $CacheFile
     *            缓存目录
     * @param string $sI18nSet
     *            语言上下文环境
     * @author 小牛
     * @since 2016.11.27
     * @return array
     */
    static public function saveToJs($Files, $sCacheFile, $sI18nSet) {
        // 读取语言包数据
        if (is_string ( $Files )) {
            $Files [] = $Files;
        }
        $arrTexts = self::parsePoData ( $Files );
        
        $sDir = dirname ( $sCacheFile );
        if (! is_dir ( $sDir )) {
            Q::makeDir ( $sDir );
        }
        // 防止空数据无法写入
        $arrTexts ['Query Yet Simple'] = 'Query Yet Simple';
        if (! file_put_contents ( $sCacheFile, "/* I18n Cache */\n;$(function(){\n    $.fn.queryphp('i18nPackage',\''.$sI18nSet.'\'," . json_encode ( $arrTexts, 256 ) . "); \n});" )) {
            Q::errorMessage ( sprintf ( 'Dir %s do not have permission.', $sCacheDir ) );
        }
        
        return $arrTexts;
    }
    
    /**
     * 保存数据到 PHP 的缓存文件
     *
     * @param
     *            string | array $Files 文件地址
     * @param string $CacheFile
     *            缓存目录
     * @author 小牛
     * @since 2016.11.27
     * @return array
     */
    static public function saveToPhp($Files, $sCacheFile) {
        // 读取语言包数据
        if (is_string ( $Files )) {
            $Files [] = $Files;
        }
        $arrTexts = self::parsePoData ( $Files );
        
        $sDir = dirname ( $sCacheFile );
        if (! is_dir ( $sDir )) {
            Q::makeDir ( $sDir );
        }
        // 防止空数据无法写入
        $arrTexts ['Query Yet Simple'] = 'Query Yet Simple';
        if (! file_put_contents ( $sCacheFile, "<?php\n /* I18n Cache */ \n return " . var_export ( $arrTexts, true ) . "\n?>" )) {
            Q::errorMessage ( sprintf ( 'Dir %s do not have permission.', $sDir ) );
        }
        
        return $arrTexts;
    }
    
    /**
     * 分析目录中的PHP和JS语言包包含的文件
     *
     * @param
     *            string | array $I18nDir 文件地址
     * @author 小牛
     * @since 2016.11.27
     * @return array
     */
    static public function findPoFile($I18nDir) {
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
                $arrFiles ['js'] = array_merge ( $arrFiles ['js'], Q::listDir ( $sDir . '/js', $arrParams ) );
            }
            if (is_dir ( $sDir . '/php' )) {
                $arrFiles ['php'] = array_merge ( $arrFiles ['php'], Q::listDir ( $sDir . '/php', $arrParams ) );
            }
        }
        
        return $arrFiles;
    }
    
    /**
     * 分析PO文件语言包数据
     *
     * @param
     *            string | array $I18nFile 文件地址
     * @author 小牛
     * @since 2016.11.25
     * @return array
     */
    static public function parsePoData($I18nFile) {
        if (is_string ( $I18nFile )) {
            $I18nFile = [ 
                    $I18nFile 
            ];
        }
        
        $sContent = '';
        foreach ( $I18nFile as $sFile ) {
            if (! is_file ( $sFile )) {
                Q::throwException ( sprintf ( 'The i18n file < %s > is not exists!', $sFile ) );
            }
            $sContent .= Q::escapeCharacter ( file_get_contents ( $sFile ) );
        }
        
        $arrResult = [ ];
        if (preg_match_all ( "/msgid \"(.*?)\"/i", $sContent, $arrSource ) && preg_match_all ( "/msgstr \"(.*?)\"/i", $sContent, $arrNew )) {
            foreach ( $arrSource [1] as $nKey => $sSource ) {
                $sSource = trim ( $sSource );
                if ($sSource) {
                    $sSource = Q::escapeCharacter ( $sSource, true );
                }
                
                if ($sSource) {
                    $sNew = trim ( $arrNew [1] [$nKey] );
                    if ($sNew) {
                        $sNew = Q::escapeCharacter ( $sNew, true );
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
