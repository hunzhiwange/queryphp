<?php

declare(strict_types=1);

namespace App\Print\Entity;

use Leevel\Database\Ddd\Entity;
use Leevel\Database\Ddd\Struct;

/**
 * 打印模板内容.
 */
final class PrintTemplateContent extends Entity
{
    /**
     * Database table.
     */
<<<<<<< HEAD
    public const string TABLE = 'print_template_content';
=======
    public const string TABLE = 'print_template_content';
>>>>>>> master

    /**
     * Database table name.
     */
<<<<<<< HEAD
    public const string TABLE_NAME = '打印模板内容';
=======
    public const string TABLE_NAME = '打印模板内容';
>>>>>>> master

    /**
     * Primary key.
     */
<<<<<<< HEAD
    public const string ID = 'id';
=======
    public const string ID = 'id';
>>>>>>> master

    /**
     * Unique Index.
     */
<<<<<<< HEAD
    public const array UNIQUE_INDEX = [
=======
    public const array UNIQUE_INDEX = [
>>>>>>> master
        'PRIMARY' => [
            'field' => ['id'],
            'comment' => 'ID',
        ],
    ];

    /**
     * Auto increment.
     */
<<<<<<< HEAD
    public const string AUTO = 'id';
=======
    public const string AUTO = 'id';
>>>>>>> master

    /**
     * Soft delete column.
     */
<<<<<<< HEAD
    public const string DELETE_AT = 'delete_at';
=======
    public const string DELETE_AT = 'delete_at';
>>>>>>> master

    public const UPDATE_PROP = 'template_id';

    #[Struct([
        self::COLUMN_NAME => 'ID',
        self::READONLY => true,
        self::COLUMN_STRUCT => [
            'type' => 'bigint',
            'default' => null,
        ],
    ])]
    protected ?int $id = null;

    #[Struct([
        self::COLUMN_NAME => '平台ID',
        self::COLUMN_STRUCT => [
            'type' => 'bigint',
            'default' => 0,
        ],
    ])]
    protected ?int $platformId = null;

    #[Struct([
        self::COLUMN_NAME => '公司ID',
        self::COLUMN_STRUCT => [
            'type' => 'bigint',
            'default' => 0,
        ],
    ])]
    protected ?int $companyId = null;

    #[Struct([
        self::COLUMN_NAME => '任务ID',
        self::COLUMN_STRUCT => [
            'type' => 'bigint',
            'default' => 0,
        ],
    ])]
    protected ?int $templateId = null;

    #[Struct([
        self::COLUMN_NAME => '内容',
        self::COLUMN_STRUCT => [
            'type' => 'text',
            'default' => null,
        ],
    ])]
    protected ?string $content = null;

    #[Struct([
        self::COLUMN_NAME => '创建时间',
        self::COLUMN_STRUCT => [
            'type' => 'datetime',
            'default' => 'CURRENT_TIMESTAMP',
        ],
    ])]
    protected ?string $createAt = null;

    #[Struct([
        self::COLUMN_NAME => '删除时间',
        self::COLUMN_COMMENT => '0=未删除;大于0=删除时间;',
        self::SHOW_PROP_BLACK => true,
        self::COLUMN_STRUCT => [
            'type' => 'bigint',
            'default' => 0,
        ],
    ])]
    protected ?int $deleteAt = null;

    #[Struct([
        self::COLUMN_NAME => '创建账号',
        self::SHOW_PROP_BLACK => true,
        self::COLUMN_STRUCT => [
            'type' => 'bigint',
            'default' => 0,
        ],
    ])]
    protected ?int $createAccount = null;

    #[Struct([
        self::COLUMN_NAME => '操作版本号',
        self::COLUMN_STRUCT => [
            'type' => 'bigint',
            'default' => 0,
        ],
    ])]
    protected ?int $version = null;
}
