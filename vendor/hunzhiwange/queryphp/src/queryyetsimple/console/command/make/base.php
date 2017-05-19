<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
namespace queryyetsimple\console\command\make;

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

use queryyetsimple\console\command;
use queryyetsimple\filesystem\directory;
use queryyetsimple\option\option;
use queryyetsimple\psr4\psr4;

/**
 * 生成器基类
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2017.05.02
 * @version 1.0
 */
abstract class base extends command {
    
    /**
     * 创建类型
     *
     * @var string
     */
    protected $strMakeType;
    /**
     * 文件保存路径
     *
     * @var string
     */
    protected $strSaveFilePath;
    
    /**
     * 模板源码
     *
     * @var string
     */
    protected $strTemplateSource;
    
    /**
     * 保存的模板结果
     *
     * @var string
     */
    protected $strTemplateResult;
    
    /**
     * 自定义替换
     *
     * @var array
     */
    protected $arrCustomReplaceKeyValue = [ ];
    
    /**
     * 响应命令
     *
     * @return void
     */
    public function handle() {
        // 替换模板变量
        $this->replaceTemplateSource_ ();
        
        // 保存文件
        if ($this->saveTemplateResult_ () === false) {
            return;
        }
        
        // 保存成功输出消息
        $this->info ( sprintf ( '%s <%s> created successfully.', $this->getMakeType_ (), $this->argument ( 'name' ) ) );
        $this->commentFilePath_ ();
    }
    
    /**
     * 替换模板变量
     *
     * @return string
     */
    protected function replaceTemplateSource_() {
        // 解析模板源码
        $this->parseTemplateSource_ ();
        
        // 获取替换变量
        $arrSourceAndReplace = $this->parseSourceAndReplace_ ();
        
        // 执行替换
        $strTemplateSource = str_replace ( $arrSourceAndReplace [0], $arrSourceAndReplace [1], $this->getTemplateSource_ () ); // 第一替换基本变量
        $this->strTemplateResult = str_replace ( $arrSourceAndReplace [0], $arrSourceAndReplace [1], $strTemplateSource ); // 第一替换基本变量中的变量
    }
    
    /**
     * 保存模板
     *
     * @return void
     */
    protected function saveTemplateResult_() {
        $strSaveFilePath = $this->getSaveFilePath_ ();
        if (! is_dir ( dirname ( $strSaveFilePath ) )) {
            directory::create ( dirname ( $strSaveFilePath ) );
        }
        if (is_file ( $strSaveFilePath )) {
            $this->error ( 'File is already exits.' );
            $this->commentFilePath_ ();
            return false;
        }
        if (! file_put_contents ( $strSaveFilePath, $this->getTemplateResult_ () )) {
            $this->error ( 'Can not write file.' );
            $this->commentFilePath_ ();
            return false;
        }
    }
    
    /**
     * 获取模板编译结果
     *
     * @return string
     */
    protected function getTemplateResult_() {
        return $this->strTemplateResult;
    }
    
    /**
     * 分析模板源码
     *
     * @return void
     */
    protected function parseTemplateSource_() {
        $strTemplateSource = dirname ( __DIR__ ) . '/template/' . str_replace ( ':', '.', $this->getName () );
        if (! is_file ( $strTemplateSource )) {
            $this->error ( 'Template not found.' );
            $this->comment ( $strTemplateSource );
            return;
        }
        $this->strTemplateSource = file_get_contents ( $strTemplateSource );
    }
    /**
     * 获取模板源码
     *
     * @return string
     */
    protected function getTemplateSource_() {
        return $this->strTemplateSource;
    }
    
    /**
     * 分析变量替换
     *
     * @return array
     */
    protected function parseSourceAndReplace_() {
        $arrReplaceKeyValue = array_merge ( $this->getDefaultReplaceKeyValue_ (), option::gets ( 'console\template' ) );
        $arrSourceKey = array_map ( function ($strItem) {
            return '{{' . $strItem . '}}';
        }, array_keys ( $arrReplaceKeyValue ) );
        $arrReplace = array_values ( $arrReplaceKeyValue );
        return [ 
                $arrSourceKey,
                $arrReplace 
        ];
    }
    
    /**
     * 取得系统的替换变量
     *
     * @return array
     */
    protected function getDefaultReplaceKeyValue_() {
        return array_merge ( [ 
                'namespace' => $this->getNamespace_ (),
                'file_name' => $this->argument ( 'name' ),
                'date_y' => date ( 'Y' ) 
        ], $this->getCustomReplaceKeyValue_ () ); // 日期年
    }
    
    /**
     * 设置文件保存路径
     *
     * @param string $strSaveFilePath            
     * @return void
     */
    protected function setSaveFilePath_($strSaveFilePath) {
        $this->strSaveFilePath = $strSaveFilePath;
    }
    
    /**
     * 读取文件保存路径
     *
     * @return void
     */
    protected function getSaveFilePath_() {
        return $this->strSaveFilePath;
    }
    
    /**
     * 获取命名空间路径
     *
     * @return string
     */
    protected function getNamespacePath_() {
        if (! ($strNamespacePath = psr4::getNamespace ( $this->getNamespace_ () ))) {
            $strNamespacePath = $this->getQueryPHP ()->path_application . '/' . $this->getNamespace_ () . '/';
        }
        return $strNamespacePath;
    }
    
    /**
     * 分析命名空间
     *
     * @return void
     */
    protected function parseNamespace_() {
        $strNamespace = $this->option ( 'namespace' );
        if (empty ( $strNamespace )) {
            $strNamespace = option::gets ( 'default_app' );
        }
        $this->setNamespace_ ( $strNamespace );
    }
    
    /**
     * 设置命名空间
     *
     * @param string $strNamespace            
     * @return void
     */
    protected function setNamespace_($strNamespace) {
        $this->strNamespace = $strNamespace;
    }
    
    /**
     * 读取命名空间
     *
     * @return void
     */
    protected function getNamespace_() {
        return $this->strNamespace;
    }
    
    /**
     * 设置创建类型
     *
     * @param string $strMakeType            
     * @return void
     */
    protected function setMakeType_($strMakeType) {
        $this->strMakeType = $strMakeType;
    }
    
    /**
     * 读取创建类型
     *
     * @return void
     */
    protected function getMakeType_() {
        return $this->strMakeType;
    }
    
    /**
     * 设置自定义变量替换
     *
     * @param mixed $mixKey            
     * @param string $strValue            
     * @return void
     */
    protected function setCustomReplaceKeyValue_($mixKey, $strValue) {
        if (is_array ( $mixKey )) {
            $this->arrCustomReplaceKeyValue = array_merge ( $this->arrCustomReplaceKeyValue, $mixKey );
        } else {
            $this->arrCustomReplaceKeyValue [$mixKey] = $strValue;
        }
    }
    
    /**
     * 读取自定义变量替换
     *
     * @param string $strMakeType            
     * @return void
     */
    protected function getCustomReplaceKeyValue_() {
        return $this->arrCustomReplaceKeyValue;
    }
    
    /**
     * 输入保存文件路径信息
     *
     * @return void
     */
    protected function commentFilePath_() {
        $this->comment ( directory::tidyPathLinux ( $this->getSaveFilePath_ () ) );
    }
}  