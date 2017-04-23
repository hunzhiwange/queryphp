<?php
/*
 * [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
 * ©2010-2017 http://queryphp.com All rights reserved.
 * 
 * ##########################################################
 * #   ____                          ______  _   _ ______   #
 * #  /     \       ___  _ __  _   _ | ___ \| | | || ___ \  # 
 * # |   (  ||(_)| / _ \| '__|| | | || |_/ /| |_| || |_/ /  #
 * #  \____/ |___||  __/| |   | |_| ||  __/ |  _  ||  __/   #
 * #       \__   | \___ |_|    \__  || |    | | | || |      #
 * #     Query Yet Simple      __/  |\_|    |_| |_|\_|      #
 * #                          |___ /  Since 2010.10.03      #
 * ##########################################################
 * 
 * @author Xiangmin Liu<635750556@qq.com>
 * @version $$
 * @date 2017.03.09
 * @since 1.0
 */
namespace Q\database;

/**
 * 数据库入口
 *
 * @author Xiangmin Liu
 */
class database {
    
    /**
     * 连接数据库并返回连接对象
     *
     * @param mixed $mixOption            
     * @return \Q\connect
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
        if (($objConnectClass = \Q::project ()->make ( $mixOption ['db_type'], $mixOption ))) {
            return $arrConnect [$strUnique] = $objConnectClass;
        } else {
            \Q::throwException ( \Q::i18n ( '数据库驱动 %s 不存在！', $mixOption ['db_type'] ), 'Q\database\exception' );
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
        if (is_string ( $mixOption ) && ! empty ( $GLOBALS ['~@option'] [$mixOption] ) && is_array ( $GLOBALS ['~@option'] [$mixOption] )) {
            $arrOption = $GLOBALS ['~@option'] [$mixOption];
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
        $arrResult = [ ];
        
        // 合并参数
        $arrOption = array_merge ( $arrOption, [ 
                'db_type' => $GLOBALS ['~@option'] ['db_type'],
                'db_schema' => $GLOBALS ['~@option'] ['db_schema'],
                'db_user' => $GLOBALS ['~@option'] ['db_user'],
                'db_password' => $GLOBALS ['~@option'] ['db_password'],
                'db_host' => $GLOBALS ['~@option'] ['db_host'],
                'db_port' => $GLOBALS ['~@option'] ['db_port'],
                'db_name' => $GLOBALS ['~@option'] ['db_name'],
                'db_prefix' => $GLOBALS ['~@option'] ['db_prefix'],
                'db_dsn' => $GLOBALS ['~@option'] ['db_dsn'],
                'db_char' => $GLOBALS ['~@option'] ['db_char'],
                'db_persistent' => $GLOBALS ['~@option'] ['db_persistent'],
                'db_distributed' => $GLOBALS ['~@option'] ['db_distributed'],
                'db_rw_separate' => $GLOBALS ['~@option'] ['db_rw_separate'],
                'db_master' => $GLOBALS ['~@option'] ['db_master'],
                'db_slave' => $GLOBALS ['~@option'] ['db_slave'] 
        ] );
        
        // 如果 DSN 字符串则进行解析
        if (! empty ( $arrOption ['db_dsn'] )) {
            $arrOption = array_merge ( $arrOption, $this->parseDsn_ ( $arrOption ['db_dsn'] ) );
        }
        
        // 合并 param 参数
        if (! empty ( $arrOption ['db_params'] )) {
            $arrOption ['db_params'] = array_merge ( $GLOBALS ['~@option'] ['db_params'], $arrOption ['db_params'] );
        } else {
            $arrOption ['db_params'] = $GLOBALS ['~@option'] ['db_params'];
        }
        
        // 剥离公共配置参数
        foreach ( [ 
                'db_distributed',
                'db_rw_separate' 
        ] as $strType ) {
            $arrResult [$strType] = $arrOption [$strType];
            unset ( $arrOption [$strType] );
        }
        $arrResult ['db_type'] = $arrOption ['db_type'];
        
        // 纠正数据库服务器参数
        foreach ( [ 
                'db_master',
                'db_slave' 
        ] as $strType ) {
            if (! is_array ( $arrOption [$strType] )) {
                $arrOption [$strType] = [ ];
            }
            $arrResult [$strType] = $arrOption [$strType];
            unset ( $arrOption [$strType] );
        }
        
        // 是否采用分布式服务器，非分布式关闭附属服务器
        if ($arrResult ['db_distributed'] !== true) {
            $arrResult ['db_slave'] = [ ];
        }
        
        // 填充数据库服务器参数
        $arrResult ['db_master'] = array_merge ( $arrResult ['db_master'], $arrOption );
        if ($arrResult ['db_slave']) {
            if (\Q::oneImensionArray ( $arrResult ['db_slave'] )) {
                $arrTemp = $arrResult ['db_slave'];
                $arrResult ['db_slave'] = [ ];
                $arrResult ['db_slave'] [] = $arrTemp;
            }
            foreach ( $arrResult ['db_slave'] as &$arrSlave ) {
                $arrSlave = array_merge ( $arrSlave, $arrOption );
            }
        }
        
        // 返回结果
        unset ( $arrOption );
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
}
