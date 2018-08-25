<?php

declare(strict_types=1);

/*
 * This file is part of the forcodepoem package.
 *
 * The PHP Application Created By Code Poem. <Query Yet Simple>
 * (c) 2018-2099 http://forcodepoem.com All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace phpui\app\controller;

use queryyetsimple\mvc\controller;

/**
 * phpui start 控制器.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.11.21
 *
 * @version 1.0
 */
class start extends controller
{
    /**
     * 默认方法.
     */
    public function index()
    {
        $this->assign('strHelloworld', 'Say hello to phpui');

        return $this->display();
    }
}
