<?php

namespace home\controller\goods;

use queryyetsimple\mvc\action;

class detail extends action {

    /**
     * 执行入口
     */
    public function run($that = null, $in = []) {
        echo '商品详情';

        // 访问父级 a 方法
        $this->controller()->a();

        //var_dump($this->controller());
    }

}