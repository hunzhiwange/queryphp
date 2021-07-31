<?php

declare(strict_types=1);

namespace App\Domain\Entity\Base;

use Leevel\Database\Ddd\Entity;
use Leevel\Database\Ddd\GetterSetter;

/**
 * 系统配置.
 */
class Option extends Entity
{
    use GetterSetter;

    /**
     * Database table.
     */
    public const TABLE = 'option';

    /**
     * Primary key.
     */
    public const ID = 'id';

    /**
     * Unique key.
     */
    public const UNIQUE = [
        ['name', 'delete_at'],
    ];

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
     *                   comment: 配置名  type: varchar(200)  null: false  
     *                   key: MUL  default:   extra: 
     * - value
     *                   comment: 配置值  type: text  null: false  
     *                   key:   default: null  extra: 
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
    public const STRUCT = [
        'id' => [
            self::COLUMN_NAME => 'ID',
            self::READONLY => true,
        ],
        'name' => [
            self::COLUMN_NAME => '配置名',
        ],
        'value' => [
            self::COLUMN_NAME => '配置值',
        ],
        'create_at' => [
            self::COLUMN_NAME => '创建时间',
        ],
        'update_at' => [
            self::COLUMN_NAME => '更新时间',
            self::SHOW_PROP_BLACK => true,
        ],
        'delete_at' => [
            self::COLUMN_NAME => '删除时间 0=未删除;大于0=删除时间;',
            self::SHOW_PROP_BLACK => true,
        ],
        'create_account' => [
            self::COLUMN_NAME => '创建账号',
            self::SHOW_PROP_BLACK => true,
        ],
        'update_account' => [
            self::COLUMN_NAME => '更新账号',
            self::SHOW_PROP_BLACK => true,
        ],
        'version' => [
            self::COLUMN_NAME => '操作版本号',
        ],
    ]; // END STRUCT

    /**
     * Soft delete column.
     */
    public const DELETE_AT = 'delete_at';

    /**
     * 站点状态.
     */
    
    #[site_status('禁用')]
    public const SITE_STATUS_DISABLE = 0;

    #[site_status('启用')]
    public const SITE_STATUS_ENABLE = 1;
}
