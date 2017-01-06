<?php
/*
 * [$MyApp] (C)QueryPHP.COM Since 2016.11.19.
 * 默认控制器
 *
 * @author dyhb<635750556@qq.com>
 * @version $$
 * @date 2016.11.19
 * @since 1.0
 */
namespace home\controller;

use Q, Q\base\controller;

/**
 * 默认控制器
 *
 * @since 2016年11月19日 下午1:41:35
 * @author dyhb
 */
class index extends controller {
    public function index() {
        $this->display ();
    }
    public function i18n() {
        $this->display ();
    }
    
    
}
