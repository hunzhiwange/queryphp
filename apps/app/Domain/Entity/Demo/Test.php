<?php

declare(strict_types=1);

namespace App\Domain\Entity\Demo;

use Leevel\Database\Ddd\Entity;
use Leevel\Database\Ddd\GetterSetter;

/**
 * 测试.
 */
class Test extends Entity
{
    use GetterSetter;

    /**
     * Database table.
     */
    public const TABLE = 'test';

    /**
     * Primary key.
     */
    public const ID = 'id';

    /**
     * Auto increment.
     */
    public const AUTO = 'id';

    /**
     * Entity struct.
     *
     * - id
     *                   comment: ID  type: bigint(20) unsigned  null: false
     *                   key: PRI  default: null  extra: auto_increment
     * - name
     *                   comment: 测试名  type: varchar(200)  null: false
     *                   key:   default:   extra:
     * - create_at
     *                   comment: 创建时间  type: datetime  null: false
     *                   key:   default: CURRENT_TIMESTAMP  extra:
     * - update_at
     *                   comment: 更新时间  type: datetime  null: false
     *                   key:   default: CURRENT_TIMESTAMP  extra: on update CURRENT_TIMESTAMP
     * - delete_at
     *                   comment: 删除时间 0=未删除;大于0=删除时间;  type: bigint(20) unsigned  null: false
     *                   key: MUL  default: 0  extra:
     * - create_account
     *                   comment: 创建账号  type: bigint(20) unsigned  null: false
     *                   key:   default: 0  extra:
     * - update_account
     *                   comment: 更新账号  type: bigint(20) unsigned  null: false
     *                   key:   default: 0  extra:
     * - version
     *                   comment: 操作版本号  type: bigint(20) unsigned  null: false
     *                   key:   default: 0  extra:
     */
    public const STRUCT = [
        'id' => [
            self::READONLY => true,
        ],
        'name' => [
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
     */
    public const DELETE_AT = 'delete_at';
}
