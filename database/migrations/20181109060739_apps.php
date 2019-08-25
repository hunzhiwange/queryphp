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

use Phinx\Migration\AbstractMigration;

class Apps extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $this->struct();
        $this->seed();
    }

    /**
     * struct.
     */
    private function struct(): void
    {
        $sql = <<<'EOT'
            CREATE TABLE `app` (
                `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `num` varchar(64) NOT NULL COMMENT '应用 ID',
                `key` varchar(64) NOT NULL COMMENT '应用 KEY',
                `secret` varchar(64) NOT NULL COMMENT '应用秘钥',
                `status` tinyint(4) unsigned NOT NULL DEFAULT '1' COMMENT '状态 0=禁用;1=启用;',
                `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
                `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
                `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
                `create_account` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
                `update_account` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
                PRIMARY KEY (`id`),
                UNIQUE KEY `num` (`num`,`delete_at`) USING BTREE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
            EOT;

        $this->execute($sql);
    }

    /**
     * seed.
     */
    private function seed(): void
    {
        $sql = <<<'EOT'
            INSERT INTO `app`(`id`, `num`, `key`, `secret`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (1, 'admin', 'B1DA4485-B49D-D8E3-0F9E-168D7605A797', '4282222', 1, '2019-04-14 22:26:25', '2019-08-25 21:19:23', 0, 0, 0);
            EOT;

        $this->execute($sql);
    }
}
