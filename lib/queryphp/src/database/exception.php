<?php
/*
 * [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
 * ©2010-2017 http://queryphp.com All rights reserved.
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @version $$
 * @date 2017.01.09
 * @since 1.0
 */
namespace Q\database;

/**
 * 数据库组件异常捕获
 *
 * @author Xiangmin Liu
 */
class exception extends \Q\exception\exception {
    
    /**
     * 构造函数
     *
     * @param string $sMessage            
     * @param number $nCode            
     * @return void
     */
    public function __construct($sMessage, $nCode = 0) {
        parent::__construct ( $sMessage, $nCode );
    }
}
