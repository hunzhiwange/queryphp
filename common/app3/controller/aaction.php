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

namespace common\app\controller;

use queryyetsimple\mvc\action;

/**
 * 基础方法器.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.10.12
 *
 * @version 1.0
 */
class aaction extends action
{
    /**
     * IOC 容器调用回调实现依赖注入.
     *
     * @param calable $calClass
     * @param array   $arrArgs
     *
     * @return mixed
     */
    public function call($calClass, array $arrArgs = [])
    {
        return $this->objController->call($calClass, $arrArgs);
    }
}
