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

namespace common\domain\repository;

use queryyetsimple\mvc\irepository;

/**
 * 权限仓储接口.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.12.11
 *
 * @version 1.0
 */
interface rule extends irepository
{
    /**
     * 取得所有记录.
     *
     * @param null|callable $mixCallback
     * @param null|mixed    $mixSpecification
     *
     * @return \queryyetsimple\support\collection
     */
    public function all($mixSpecification = null);

    /**
     * 是否存在子菜单.
     *
     * @param int $nId
     *
     * @return bool
     */
    public function hasChildren($nId);

    /**
     * 最早(后)一个兄弟节点.
     *
     * @param int    $nId
     * @param string $strSort
     * @param mixed  $nPid
     *
     * @return mixed
     */
    public function siblingNodeBySort($nPid, $strSort = 'ASC');
}
