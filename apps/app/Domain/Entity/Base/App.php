<?php

declare(strict_types=1);

namespace App\Domain\Entity\Base;

use Leevel\Database\Ddd\Entity;
use Leevel\Database\Ddd\GetterSetter;

/**
 * 应用.
 */
class App extends Entity
{
    use GetterSetter;

    /**
     * Database table.
     */
    const TABLE = 'app';

    /**
     * Primary key.
     */
    const ID = 'id';

    /**
     * Auto increment.
     */
    const AUTO = 'id';

    /**
     * Entity struct.
     *
     * - id
     *                   comment: ID  type: bigint(20) unsigned  null: false
     *                   key: PRI  default: null  extra: auto_increment
     * - num
     *                   comment: 应用 ID  type: varchar(64)  null: false
     *                   key: MUL  default:   extra:
     * - key
     *                   comment: 应用 KEY  type: varchar(64)  null: false
     *                   key:   default:   extra:
     * - secret
     *                   comment: 应用秘钥  type: varchar(64)  null: false
     *                   key:   default:   extra:
     * - status
     *                   comment: 状态 0=禁用;1=启用;  type: tinyint(4) unsigned  null: false
     *                   key:   default: 1  extra:
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
     */
    const STRUCT = [
        'id' => [
            self::READONLY => true,
        ],
        'num' => [
        ],
        'key' => [
        ],
        'secret' => [
        ],
        'status' => [
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
    const DELETE_AT = 'delete_at';

    /**
     * 状态值.
     */
    
    #[status('禁用')]
    const STATUS_DISABLE = 0;

    #[status('启用')]
    const STATUS_ENABLE = 1;
}
