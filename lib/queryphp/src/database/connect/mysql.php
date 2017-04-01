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
     * sql 字段格式化
     *
     * @return string
     */
    public function identifierColumn($sName) {
        return $sName != '*' ? "`{$sName}`" : '*';
    }
  
}
