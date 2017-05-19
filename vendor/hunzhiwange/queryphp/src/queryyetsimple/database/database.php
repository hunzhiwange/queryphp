<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
namespace queryyetsimple\database;

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
use queryyetsimple\traits\dynamic\expansion as dynamic_expansion;
use queryyetsimple\option\option;
use queryyetsimple\helper\helper;

/**
 * 数据库入口
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2017.03.09
 * @version 1.0
 */
class database {
    
    use dynamic_expansion;
    
    /**
     * 配置
     *
     * @var array
     */
    protected $arrInitExpansionInstanceArgs = [ 
            'database\type' => 'mysql',
            'database\schema' => '',
            'database\user' => 'root',
            'database\password' => '',
            'database\host' => 'localhost',
            'database\port' => 3306,
            'database\name' => '',
            'database\prefix' => '',
            'database\dsn' => '',
            'database\params' => [ ],
            'database\char' => 'utf8',
            'database\persistent' => false,
            'database\distributed' => false,
            'database\rw_separate' => false,
            'database\master' => [ ],
            'database\slave' => [ ] 
    ];
    
    /**
     * 连接数据库并返回连接对象
     *
     * @param mixed $mixOption            
     * @return \queryyetsimple\connect
     */
    public function connect($mixOption = null) {
        static $arrConnect;
        
        // 连接唯一标识
        $strUnique = md5 ( is_array ( $mixOption ) ? json_encode ( $mixOption ) : $mixOption );
        
        // 已经存在直接返回
        if (isset ( $arrConnect [$strUnique] )) {
            return $arrConnect [$strUnique];
        }
        
        // 解析数据库配置
        $mixOption = $this->parseOption_ ( $mixOption );

        // 连接数据库
        $strConnectClass = '\\queryyetsimple\\database\\' . $mixOption ['database\type'];
        if (class_exists ( $strConnectClass )) {
            return $arrConnect [$strUnique] = new $strConnectClass ( $mixOption );
        } else {
            exceptions::throwException ( __ ( '数据库驱动 %s 不存在！', $mixOption ['db_type'] ), 'queryyetsimple\database\exception' );
        }
    }
    
    /**
     * 解析数据库连接参数
     *
     * @param string $mixOption            
     * @return array
     */
    private function parseOption_($mixOption = null) {
        $arrOption = [ ];
        
        // 配置文件存在链接
        if (is_string ( $mixOption ) && is_array ( option::gets ( 'database\\'.$mixOption ) )) {
            $arrOption = option::gets ( 'database\\'.$mixOption );
        }        

        // 数组类配置
        elseif (is_array ( $mixOption )) {
            $arrOption = $mixOption;
        }
        
        // 补全结果
        return $this->fillOption_ ( $arrOption );
    }
    
    /**
     * 填充数据库配置参数
     *
     * @param array $arrOption            
     * @return array
     */
    private function fillOption_($arrOption = []) {
        // 返回结果
        $arrResult = $arrDefaultOption = [ ];
        
        // 默认参数
        foreach ( $this->initExpansionInstanceArgs_ () as $sOptionType ) {
            $arrDefaultOption [$sOptionType] = $this->getExpansionInstanceArgs_ ( $sOptionType );
        }
        
        // 合并参数
        $arrOption = array_merge ( $arrOption, $arrDefaultOption );
        
        // 如果 DSN 字符串则进行解析
        if (! empty ( $arrOption ['database\dsn'] )) {
            $arrOption = array_merge ( $arrOption, $this->parseDsn_ ( $arrOption ['database\dsn'] ) );
        }
        
        // 剥离公共配置参数
        foreach ( [ 
                'database\distributed',
                'database\rw_separate' 
        ] as $strType ) {
            $arrResult [$strType] = $arrOption [$strType];
            unset ( $arrOption [$strType] );
        }
        $arrResult ['database\type'] = $arrOption ['database\type'];
        
        // 纠正数据库服务器参数
        foreach ( [ 
                'database\master',
                'database\slave' 
        ] as $strType ) {
            if (! is_array ( $arrOption [$strType] )) {
                $arrOption [$strType] = [ ];
            }
            $arrResult [$strType] = $arrOption [$strType];
            unset ( $arrOption [$strType] );
        }
        
        // 是否采用分布式服务器，非分布式关闭附属服务器
        if ($arrResult ['database\distributed'] !== true) {
            $arrResult ['database\slave'] = [ ];
        }
        
        // 填充数据库服务器参数
        $arrResult ['database\master'] = array_merge ( $arrResult ['database\master'], $arrOption );
        if ($arrResult ['database\slave']) {
            if (count ( $arrResult ['database\slave'] ) == count ( $arrResult ['database\slave'], 1 )) {
                $arrResult ['database\slave'] = [ 
                        $arrResult ['database\slave'] 
                ];
            }
            foreach ( $arrResult ['database\slave'] as &$arrSlave ) {
                $arrSlave = array_merge ( $arrSlave, $arrOption );
            }
        }
        
        // + 合并支持
        $arrResult = helper::arrayMergePlus ( $arrResult );
        
        // 返回结果
        unset ( $arrOption, $arrDefaultOption );
        return $arrResult;
    }
    
    /**
     * 解析数据库连接数据源
     *
     * @param string $strDsn            
     * @return array
     */
    private function parseDsn_($strDsn) {
        $strDsn = trim ( $strDsn );
        
        // dsn 为空，直接返回
        if (empty ( $strDsn )) {
            return [ ];
        }
        
        // 分析dsn参数
        $arrDsn = parse_url ( $strDsn );
        if ($arrDsn ['scheme']) {
            return [ 
                    'db_type' => $arrDsn ['scheme'],
                    'db_schema' => $arrDsn ['scheme'],
                    'db_user' => isset ( $arrDsn ['user'] ) ? $arrDsn ['user'] : '',
                    'db_password' => isset ( $arrDsn ['pass'] ) ? $arrDsn ['pass'] : '',
                    'db_host' => isset ( $arrDsn ['host'] ) ? $arrDsn ['host'] : '',
                    'db_port' => isset ( $arrDsn ['port'] ) ? $arrDsn ['port'] : '',
                    'db_name' => isset ( $arrDsn ['path'] ) ? substr ( $arrDsn ['path'], 1 ) : '' 
            ];
        } else {
            if (preg_match ( '/^(.*?)\:\/\/(.*?)\:(.*?)\@(.*?)\:([0-9]{1,6})\/(.*?)$/', $strDsn, $arrMat )) {
                return [ 
                        'db_type' => $arrMat [1],
                        'db_schema' => $arrMat [1],
                        'db_user' => $arrMat [2],
                        'db_password' => $arrMat [3],
                        'db_host' => $arrMat [4],
                        'db_port' => $arrMat [5],
                        'db_name' => $arrMat [6] 
                ];
            }
        }
    }
    
    /**
     * 拦截匿名注册控制器方法
     *
     * @param 方法名 $sMethod            
     * @param 参数 $arrArgs            
     * @return mixed
     */
    public function __call($sMethod, $arrArgs) {
        return call_user_func_array ( [ 
                $this->connect (),
                $sMethod 
        ], $arrArgs );
    }
}
