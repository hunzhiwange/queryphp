<?php

declare(strict_types=1);

/*
 * This file is part of the your app package.
 *
 * The PHP Application For Code Poem For You.
 * (c) 2018-2099 http://yourdomian.com All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Common\Domain\Entity\User;

use Leevel\Database\Ddd\Entity;
use Leevel\Database\Ddd\GetterSetter;

/**
 * 权限资源关联.
 */
class PermissionResource extends Entity
{
    use GetterSetter;

    /**
     * Database table.
     *
     * @var string
     */
    const TABLE = 'permission_resource';

    /**
     * Primary key.
     *
     * @var string
     */
    const ID = 'id';

    /**
     * Auto increment.
     *
     * @var string
     */
    const AUTO = 'id';

    /**
     * Entity struct.
     *
     * - id
     *                   comment: ID  type: bigint(20) unsigned  null: false
     *                   key: PRI  default: null  extra: auto_increment
     * - permission_id
     *                   comment: 权限 ID  type: bigint(20) unsigned  null: false
     *                   key: MUL  default: 0  extra:
     * - resource_id
     *                   comment: 资源 ID  type: bigint(20) unsigned  null: false
     *                   key:   default: 0  extra:
     * - create_at
     *                   comment: 创建时间  type: datetime  null: false
     *                   key:   default: CURRENT_TIMESTAMP  extra:
     * - update_at
     *                   comment: 更新时间  type: datetime  null: false
     *                   key:   default: CURRENT_TIMESTAMP  extra: on update CURRENT_TIMESTAMP
     * - delete_at
     *                   comment: 删除时间 0=未删除;大于0=删除时间;  type: bigint(20) unsigned  null: false
     *                   key:   default: 0  extra:
     * - create_account
     *                   comment: 创建账号  type: bigint(20) unsigned  null: false
     *                   key:   default: 0  extra:
     * - update_account
     *                   comment: 更新账号  type: bigint(20) unsigned  null: false
     *                   key:   default: 0  extra:
     * - version
     *                   comment: 操作版本号  type: bigint(20) unsigned  null: false
     *                   key:   default: 0  extra:
     *
     * @var array
     */
    const STRUCT = [
        'id' => [
            self::READONLY => true,
        ],
        'permission_id' => [
        ],
        'resource_id' => [
        ],
        'create_at' => [
        ],
        'update_at' => [
            self::SHOW_PROP_BLACK => true,
        ],
        'delete_at' => [
            self::SHOW_PROP_BLACK => true,
        ],
        'create_account' => [
            self::SHOW_PROP_BLACK => true,
        ],
        'update_account' => [
            self::SHOW_PROP_BLACK => true,
        ],
        'version' => [
        ],
    ];

    /**
     * Soft delete column.
     *
     * @var string
     */
    const DELETE_AT = 'delete_at';
}
