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

use queryyetsimple\operating\system;

/**
 * 文件夹
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2017.04.05
 * @version 4.0
 */
class directory {
    
    /**
     * 创建目录
     *
     * @param string $sDir            
     * @param number $nMode            
     * @return boolean
     */
    public static function create($sDir, $nMode = 0777) {
        if (is_dir ( $sDir )) {
            return true;
        }
        
        if (is_string ( $sDir )) {
            $sDir = explode ( '/', str_replace ( '\\', '/', trim ( $sDir, '/' ) ) );
        }
        
        $sCurDir = system::isWindows () ? '' : '/';
        
        foreach ( $sDir as $nKey => $sTemp ) {
            $sCurDir .= $sTemp . '/';
            if (! is_dir ( $sCurDir )) {
                if (isset ( $sDir [$nKey + 1] ) && is_dir ( $sCurDir . $sDir [$nKey + 1] )) {
                    continue;
                }
                @mkdir ( $sCurDir, $nMode );
            }
        }
        
        return true;
    }
    
    /**
     * 删除目录
     *
     * @param string $sDir            
     * @param boolean $bRecursive            
     * @return bool
     */
    public static function delete($sDir, $bRecursive = false) {
        if (! file_exists ( $sDir ) || ! is_dir ( $sDir ))
            return true;
        
        if (! $bRecursive) {
            return rmdir ( $sDir );
        } else {
            $hDir = opendir ( $sDir );
            while ( ($sFile = readdir ( $hDir )) !== false ) {
                if (in_array ( $sFile, [ 
                        '.',
                        '..' 
                ] )) {
                    continue;
                }
                $sFile = $sDir . '/' . $sFile;
                if (is_file ( $sFile )) {
                    if (! unlink ( $sFile ))
                        return false;
                } elseif (is_dir ( $sFile )) {
                    return static::delete ( $sFile, $bRecursive );
                }
            }
            closedir ( $hDir );
            return rmdir ( $sDir );
        }
    }
    
    /**
     * 复制目录
     *
     * @param string $sSourcePath            
     * @param string $sTargetPath            
     * @return bool
     */
    public static function copy($sSourcePath, $sTargetPath, $arrFilter = []) {
        $arrFilter = array_merge ( [ 
                '.',
                '..',
                '.svn',
                '.git',
                'node_modules',
                '.gitkeep' 
        ], $arrFilter );
        
        if (! is_dir ( $sSourcePath )) {
            return false;
        }
        if (file_exists ( $sTargetPath )) {
            return false;
        }
        
        $hDir = opendir ( $sSourcePath );
        while ( ($sFile = readdir ( $hDir )) !== false ) {
            if (in_array ( $sFile, $arrFilter )) {
                continue;
            }
            
            $sFile = $sSourcePath . '/' . $sFile;
            $sNewPath = $sTargetPath . '/' . $sFile;
            
            if (is_file ( $sFile )) {
                if (! is_dir ( $sNewPath )) {
                    static::create ( dirname ( $sNewPath ) );
                }
                if (! copy ( $sFile, $sNewPath )) {
                    return false;
                }
            } 

            elseif (is_dir ( $sFile )) {
                if (! static::copy ( $sFile, $sNewPath )) {
                    return false;
                }
            }
        }
        closedir ( $hDir );
        
        return true;
    }
    
    /**
     * 只读取一级目录
     *
     * @param 目录 $sDir            
     * @param array $arrIn
     *            fullpath 是否返回全部路径
     *            returndir 返回目录
     * @return array
     */
    public static function lists($sDir, $arrIn = []) {
        $arrIn = array_merge ( [ 
                'fullpath' => false,
                'return' => 'dir', // file dir both
                'filterdir' => [ 
                        '.',
                        '..',
                        '.svn',
                        '.git',
                        'node_modules',
                        '.gitkeep' 
                ],
                'filterext' => [ ] 
        ], $arrIn );
        $arrReturnData = [ 
                'file' => [ ],
                'dir' => [ ] 
        ];
        if (is_dir ( $sDir )) {
            $arrFiles = [ ];
            $hDir = opendir ( $sDir );
            while ( ($sFile = readdir ( $hDir )) !== false ) {
                if (in_array ( $sFile, $arrIn ['filterdir'] )) {
                    continue;
                }
                if (is_dir ( $sDir . "/" . $sFile ) && in_array ( $arrIn ['return'], [ 
                        'dir',
                        'both' 
                ] )) {
                    $arrReturnData ['dir'] [] = ($arrIn ['fullpath'] ? $sDir . "/" : '') . $sFile;
                }
                if (is_file ( $sDir . "/" . $sFile ) && in_array ( $arrIn ['return'], [ 
                        'file',
                        'both' 
                ] ) && (! $arrIn ['filterext'] ? true : (in_array ( file::getExtName ( $sFile, 2 ), $arrIn ['filterext'] ) ? false : true))) {
                    $arrReturnData ['file'] [] = ($arrIn ['fullpath'] ? $sDir . "/" : '') . $sFile;
                }
            }
            closedir ( $hDir );
            
            if ($arrIn ['return'] == 'file') {
                return $arrReturnData ['file'];
            } elseif ($arrIn ['return'] == 'dir') {
                return $arrReturnData ['dir'];
            } else {
                return $arrReturnData;
            }
        } else {
            return [ ];
        }
    }
    
    /**
     * 整理目录斜线风格
     *
     * @param string $sPath            
     * @param boolean $bUnix            
     * @return string
     */
    public static function tidyPath($sPath, $bUnix = true) {
        $sRetPath = str_replace ( '\\', '/', $sPath ); // 统一 斜线方向
        $sRetPath = preg_replace ( '|/+|', '/', $sRetPath ); // 归并连续斜线
        
        $arrDirs = explode ( '/', $sRetPath ); // 削除 .. 和 .
        $arrDirsTemp = [ ];
        while ( ($sDirName = array_shift ( $arrDirs )) !== null ) {
            if ($sDirName == '.') {
                continue;
            }
            
            if ($sDirName == '..') {
                if (count ( $arrDirsTemp )) {
                    array_pop ( $arrDirsTemp );
                    continue;
                }
            }
            
            array_push ( $arrDirsTemp, $sDirName );
        }
        
        $sRetPath = implode ( '/', $arrDirsTemp ); // 目录 以 '/' 结尾
        if (@is_dir ( $sRetPath )) { // 存在的目录
            if (! preg_match ( '|/$|', $sRetPath )) {
                $sRetPath .= '/';
            }
        } else if (preg_match ( "|\.$|", $sPath )) { // 不存在，但是符合目录的格式
            if (! preg_match ( '|/$|', $sRetPath )) {
                $sRetPath .= '/';
            }
        }
        
        $sRetPath = str_replace ( ':/', ':\\', $sRetPath ); // 还原 驱动器符号
        if (! $bUnix) { // 转换到 Windows 斜线风格
            $sRetPath = str_replace ( '/', '\\', $sRetPath );
        }
        
        $sRetPath = rtrim ( $sRetPath, '\\/' ); // 删除结尾的“/”或者“\”
        
        return $sRetPath;
    }
    
    /**
     * 判断是否为绝对路径
     *
     * @param string $sPath            
     * @return boolean
     */
    public static function isAbsolute($sPath) {
        return preg_match ( '/^(\/|[a-z]:)/i', $sPath );
    }
    
    /**
     * 格式化文件或者目录为 Linux 风格
     *
     * @param string $strPath            
     * @param boolean $booWindowsWithLetter            
     * @return string
     */
    public static function tidyPathLinux($strPath, $booWindowsWithLetter = false) {
        $strPath = ltrim ( static::tidyPath ( $strPath, true ), '//' );
        if (strpos ( $strPath, ':\\' ) !== false) {
            $arrTemp = explode ( ':\\', $strPath );
            $strPath = ($booWindowsWithLetter === true ? strtolower ( $arrTemp [0] ) . '/' : '') . $arrTemp [1];
        }
        return '/' . $strPath;
    }
    
    /**
     * 根据 ID 获取打散目录
     *
     * @param int $intDataId            
     * @return array
     */
    public static function distributed($intDataId) {
        $intDataId = abs ( intval ( $intDataId ) );
        $intDataId = sprintf ( "%09d", $intDataId );
        
        exit ();
        $nDir1 = substr ( $nUid, 0, 3 );
        $nDir2 = substr ( $nUid, 3, 2 );
        $nDir3 = substr ( $nUid, 5, 2 );
        return [ 
                $nDir1 . '/' . $nDir2 . '/' . $nDir3 . '/',
                substr ( $nUid, - 2 ) 
        ];
    }
}
