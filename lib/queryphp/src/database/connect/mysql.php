<?php
/*
 * [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
 * ©2010-2017 http://queryphp.com All rights reserved.
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @version $$
 * @date 2017.03.09
 * @since 1.0
 */
namespace Q\database\connect;

use PDO;
use Q\database\connect;

/**
 * 数据库连接
 *
 * @author Xiangmin Liu
 */
class mysql extends connect {
    
    /**
     * dsn 解析
     *
     * @param array $arrOption            
     * @return string
     */
    protected function parseDsn_($arrOption) {
        $strDsn = 'mysql:dbname=' . $arrOption ['db_name'] . ';host=' . $arrOption ['db_host'];
        if (! empty ( $arrOption ['db_port'] )) {
            $strDsn .= ';port=' . $arrOption ['db_port'];
        }        

        // http://blogread.cn/it/article/6501
        // 用unix socket加速php-fpm、mysql、redis的连接
        elseif (! empty ( $arrOption ['socket'] )) {
            $strDsn .= ';unix_socket=' . $arrOption ['socket'];
        }
        
        // 编码
        if (! empty ( $arrOption ['db_char'] )) {
            $strDsn .= ';charset=' . $arrOption ['db_char'];
        }
        
        return $strDsn;
    }
    
    /**
     * 取得数据库表名列表
     *
     * @param string $sDbName            
     * @param mixed $mixMaster            
     * @return array
     */
    public function getTableNames($sDbName = null, $mixMaster = false) {
        // 确定数据库
        if ($sDbName === null) {
            $sDbName = $this->getCurrentOption ()['db_name'];
        }
        $strSql = 'SHOW TABLES FROM ' . $this->qualifyTableOrColumn ( $sDbName );
        $arrResult = [ ];
        if (($arrTables = $this->query ( $strSql, [ ], $mixMaster, PDO::FETCH_ASSOC ))) {
            foreach ( $arrTables as $arrTable ) {
                $arrResult [] = reset ( $arrTable );
            }
        }
        unset ( $arrTables, $strSql );
        return $arrResult;
    }
    
    /**
     * 取得数据库表字段信息
     *
     * @param string $sTableName            
     * @param string $mixMaster            
     * @return array
     */
    public function getTableColumns($sTableName, $mixMaster = false) {
        $strSql = 'SHOW FULL COLUMNS FROM ' . $this->qualifyTableOrColumn ( $sTableName );
        $arrResult = [ 
                'list' => [ ],
                'primary_key' => [ ],
                'auto_increment' => null 
        ];
        
        if (($arrColumns = $this->query ( $strSql, [ ], $mixMaster, PDO::FETCH_ASSOC ))) {
            foreach ( $arrColumns as $arrColumn ) {
                // 处理字段
                $arrTemp = [ ];
                $arrTemp ['name'] = $arrColumn ['Field'];
                $arrTemp ['type'] = $arrColumn ['Type'];
                $arrTemp ['primary_key'] = strtolower ( $arrColumn ['Key'] ) == 'pri';
                $arrTemp ['auto_increment'] = strpos ( $arrColumn ['Extra'], 'auto_increment' ) !== false;
                if (! is_null ( $arrColumn ['Default'] ) && strtolower ( $arrColumn ['Default'] ) != 'null') {
                    $arrTemp ['default'] = $arrColumn ['Default'];
                } else {
                    $arrTemp ['default'] = null;
                }
                
                // 返回结果
                $arrResult ['list'] [$arrTemp ['name']] = $arrTemp;
                if ($arrTemp ['auto_increment']) {
                    $arrResult ['auto_increment'] = $arrTemp ['name'];
                }
                if ($arrTemp ['primary_key']) {
                    $arrResult ['primary_key'] [] = $arrTemp ['name'];
                }
            }
        }
        unset ( $arrColumns, $strSql );
        return $arrResult;
    }
    
    /**
     * sql 字段格式化
     *
     * @return string
     */
    public function identifierColumn($sName) {
        return $sName != '*' ? "`{$sName}`" : '*';
    }
}
