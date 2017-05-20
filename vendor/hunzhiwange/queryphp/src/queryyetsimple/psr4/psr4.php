<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
namespace queryyetsimple\psr4;

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
use queryyetsimple\helper\helper;
use queryyetsimple\filesystem\directory;

/**
 * psr4 自动载入规范
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2016.11.17
 * @version 1.0
 */
class psr4 {
    
    /**
     * 是否启用自动载入
     *
     * @var boolean
     */
    private static $bAutoLoad = true;
    
    /**
     * 命名空间映射,具有顺序性
     *
     * @var array
     */
    private static $arrNamespace = [ ];
    
    /**
     * 命名空间缓存文件
     *
     * @var array
     */
    private static $sCachePackagePath;
    
    /**
     * 命名空间缓存
     *
     * @var string
     */
    const NAMESPACE_CACHE = '.namespace';
    
    /**
     * 自动载入
     * 基于 PSR-4 规范构建
     *
     * @param string $sClassName
     *            当前的类名
     * @return mixed
     */
    public static function autoLoad($sClassName) {
        if (static::$bAutoLoad === false) {
            return;
        }
        
        if ($sClassName {0} == '\\') {
            $sClassName = ltrim ( $sClassName, '\\' );
        }
        
        /**
         * 非命名空间的类
         */
        if (strpos ( $sClassName, '\\' ) === false) {
            $sFile = str_replace ( '_', '\\', $sClassName ) . '.php';
            return static::requireFile_ ( $sFile );
        } else {
            $sPrefix = $sClassName;
            while ( false !== ($intPos = strrpos ( $sPrefix, '\\' )) ) {
                $sPrefix = substr ( $sClassName, 0, $intPos + 1 );
                $sRelativeClass = substr ( $sClassName, $intPos + 1 );
                $sMappedFile = static::loadMappedFile_ ( $sPrefix, $sRelativeClass );
                if ($sMappedFile) {
                    return $sMappedFile;
                }
                $sPrefix = rtrim ( $sPrefix, '\\' );
            }
        }
    }
    
    /**
     * 结合 autoload 判断 class 是否存在
     *
     * @param string $sClassName            
     * @param boolean $bInterface            
     * @param boolean $bAutoload            
     * @return boolean
     */
    public static function classExists($sClassName, $bInterface = false, $bAutoload = false) {
        $bAutoloadOld = self::setAutoload ( $bAutoload );
        $sFuncName = $bInterface ? 'interface_exists' : 'class_exists';
        $bResult = $sFuncName ( $sClassName );
        self::setAutoload ( $bAutoloadOld );
        return $bResult;
    }
    
    /**
     * 导入一个目录中命名空间结构
     *
     * @param string|array $mixNamespace
     *            命名空间名字
     * @param string $sPackage
     *            命名空间路径
     * @param 支持参数 $in
     *            ignore 忽略扫描目录
     *            force 是否强制更新缓存
     * @return void
     */
    public static function import($mixNamespace, $sPackage, $in = []) {
        $in = array_merge ( [ 
                'ignore' => [ ],
                'force' => false 
        ], $in );
        
        // 虚拟应用不用创建目录
        if (! is_dir ( $sPackage )) {
            return;
        }
        
        // 包路径
        $sPackagePath = realpath ( $sPackage );
        $sCache = (static::$sCachePackagePath ?  : $sPackagePath) . '/' . (is_array ( $mixNamespace ) ? reset ( $mixNamespace ) : $mixNamespace) . static::NAMESPACE_CACHE;
        $sPackagePath .= '/';
        
        if ($in ['force'] === true || ! is_file ( $sCache )) {
            // 扫描命名空间
            $arrPath = static::scanNamespace_ ( $sPackagePath, $sPackagePath, [ 
                    'ignore' => $in ['ignore'] 
            ] );
            
            // 写入文件
            if (! is_dir ( dirname ( $sCache ) )) {
                directory::create ( dirname ( $sCache ) );
            }
            if (! file_put_contents ( $sCache, json_encode ( $arrPath ) )) {
                exceptions::throwException ( sprintf ( 'Can not create cache file: %s', $sCache ) );
            }
        } else {
            $arrPath = static::readCache_ ( $sCache );
        }
        
        if (! is_array ( $mixNamespace )) {
            $mixNamespace = [ 
                    $mixNamespace 
            ];
        }
        
        foreach ( $mixNamespace as $sNamespace ) {
            static::addNamespace ( $sNamespace, $sPackage );
            foreach ( $arrPath as $sPath ) {
                static::addNamespace ( $sNamespace . '\\' . $sPath, $sPackage . '/' . $sPath );
            }
        }
    }
    
    /**
     * 添加一个命名空间别名
     *
     * @param string $namespace
     *            命名空间前缀
     * @param mixed:string|array $baseDir
     *            命名空间的对应路径
     * @param array $in
     *            额外参数
     *            bool prepend true 表示插入命名空间前面，优先路径
     * @return void
     */
    public static function addNamespace($sNamespace, $mixBaseDir, $in = []) {
        $in = array_merge ( [ 
                'prepend' => false 
        ], $in );
        
        // 多个目录同时传入
        if (! is_array ( $mixBaseDir )) {
            $mixBaseDir = [ 
                    $mixBaseDir 
            ];
        }
        
        // 导入
        $sNamespace = trim ( $sNamespace, '\\' ) . '\\';
        if (isset ( static::$arrNamespace [$sNamespace] ) === false) {
            static::$arrNamespace [$sNamespace] = [ ];
        }
        
        foreach ( $mixBaseDir as $sBase ) {
            $sBase = rtrim ( $sBase, '/' ) . DIRECTORY_SEPARATOR;
            $sBase = rtrim ( $sBase, DIRECTORY_SEPARATOR ) . '/';
            
            // 优先插入
            if ($in ['prepend'] === true) {
                array_unshift ( static::$arrNamespace [$sNamespace], $sBase );
            } else {
                array_push ( static::$arrNamespace [$sNamespace], $sBase );
            }
        }
    }
    
    /**
     * 导入 Composer PSR-4
     *
     * @param string $strVendor            
     * @return void
     */
    public static function importComposerPsr4($strPsr4) {
        if (is_file ( $strPsr4 )) {
            $arrMap = require $strPsr4;
            foreach ( $arrMap as $sNamespace => $sPath ) {
                static::addNamespace ( $sNamespace, $sPath );
            }
        }
    }
    
    /**
     * 导入 Composer
     *
     * @param string $strVendor            
     * @return void
     */
    public static function importComposer($strVendor) {
        if (is_file ( $strVendor . '/autoload.php' )) {
            require $strVendor . '/autoload.php';
        }
    }
    
    /**
     * 获取命名空间路径
     *
     * @param string $sNamespace            
     * @return string|null
     */
    public static function getNamespace($sNamespace) {
        $sNamespace .= '\\';
        return isset ( static::$arrNamespace [$sNamespace] ) ? array_shift ( static::$arrNamespace [$sNamespace] ) : null;
    }
    
    /**
     * 根据命名空间取得文件路径
     *
     * @param string $strFile            
     * @return string
     */
    public static function getFilePath($strFile) {
        $arrTemp = explode ( '\\', $strFile );
        $strFileName = array_pop ( $arrTemp );
        $strNamespace = implode ( '\\', $arrTemp );
        if (($strNamespace = static::getNamespace ( $strNamespace ))) {
            return $strNamespace . $strFileName . '.php';
        } else {
            return $strFile . '.php';
        }
    }
    
    /**
     * 设置命名空间包缓存文件地址
     *
     * @param string $sCachePackagePath            
     * @return void
     */
    public static function cachePackagePath($sCachePackagePath) {
        static::$sCachePackagePath = $sCachePackagePath;
    }
    
    /**
     * 设置自动载入是否启用
     *
     * @param bool $bAutoload
     *            true　表示启用
     * @return boolean
     */
    public static function setAutoload($bAutoload) {
        $bOldValue = static::$bAutoLoad;
        static::$bAutoLoad = $bAutoload ? true : false;
        return $bOldValue;
    }
    
    /**
     * 读取 json 缓存数据
     *
     * @param
     *            $sCacheFile
     * @return array
     */
    private static function readCache_($sCacheFile) {
        return json_decode ( file_get_contents ( $sCacheFile ) );
    }
    
    /**
     * 从命名空间映射获取文件地址
     *
     * @param string $sPrefix
     *            命名空间前缀
     * @param string $sRelativeClass
     *            类名字
     * @return string|false 存在则为文件名，不存则返回 false
     */
    private static function loadMappedFile_($sPrefix, $sRelativeClass) {
        if (isset ( static::$arrNamespace [$sPrefix] ) === false) {
            return false;
        }
        
        foreach ( static::$arrNamespace [$sPrefix] as $bBaseDir ) {
            $sFile = $bBaseDir . str_replace ( '\\', '/', $sRelativeClass ) . '.php';
            if (static::requireFile_ ( $sFile )) {
                return $sFile;
            }
        }
        
        return false;
    }
    
    /**
     * 文件存在则载入文件
     *
     * @param string $sFile
     *            待载入的文件
     * @return bool true 表示存在， false 表示不存在
     */
    private static function requireFile_($sFile) {
        if (is_file ( $sFile )) {
            require $sFile;
            return true;
        }
        return false;
    }
    
    /**
     * 扫描一个目录的命名空间
     *
     * @param string $sDirectory
     *            待扫描的目录
     * @param string $sRootDir
     *            根目录
     * @param array $in
     *            参数配置
     *            ignore 忽略扫描目录
     *            full_path 是否返回完整路径
     * @return array 扫描后的命名空间数据
     */
    private static function scanNamespace_($sDirectory, $sRootDir = '', $in = []) {
        $in = array_merge ( [ 
                '+ignore' => [ 
                        '.',
                        '..',
                        '.svn',
                        'node_modules',
                        '.git',
                        '~@~',
                        'resource',
                        'www',
                        'ignore',
                        '.gitkeep' 
                ],
                'full_path' => false 
        ], $in );
        
        if (! class_exists ( 'queryyetsimple\helper\helper', false ) && ! class_exists ( 'queryyetsimple\helper\helper' )) {
            require __DIR__ . '/../helper/helper.php';
        }
        $in = helper::arrayMergePlus ( $in );
        
        $arrReturn = [ ];
        $sDirectoryPath = realpath ( $sDirectory ) . '/';
        $hDir = opendir ( $sDirectoryPath );
        
        while ( ($sFilename = readdir ( $hDir )) !== false ) {
            $sPath = $sDirectoryPath . $sFilename;
            if (is_dir ( $sPath )) { // 目录
                if (in_array ( $sFilename, $in ['ignore'] )) { // 排除特殊目录
                    continue;
                } else {
                    // 返回完整路径
                    if ($in ['full_path'] === true) {
                        $arrReturn [] = $sPath;
                    } else {
                        $arrReturn [] = str_replace ( str_replace ( '/', '\\', $sRootDir ), '', str_replace ( '/', '\\', $sPath ) );
                    }
                    
                    // 递归子目录
                    $arrReturn = array_merge ( $arrReturn, static::scanNamespace_ ( $sPath, $sRootDir, $in ) );
                }
            }
        }
        
        return $arrReturn;
    }
}
