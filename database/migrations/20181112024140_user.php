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

class User extends AbstractMigration
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
            CREATE TABLE `user` (
                `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
                `name` varchar(64) NOT NULL DEFAULT '' COMMENT '用户名字',
                `num` varchar(64) NOT NULL DEFAULT '' COMMENT '编号',
                `password` varchar(255) NOT NULL DEFAULT '' COMMENT '密码',
                `email` varchar(100) NOT NULL DEFAULT '' COMMENT 'Email',
                `mobile` char(11) NOT NULL DEFAULT '' COMMENT '手机',
                `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态 0=禁用;1=启用;',
                `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
                `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
                `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
                `create_account` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
                `update_account` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
                `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
                PRIMARY KEY (`id`),
                UNIQUE KEY `num` (`num`,`delete_at`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户';
            EOT;

        $this->execute($sql);
    }

    /**
     * seed.
     */
    private function seed(): void
    {
        $sql = <<<'EOT'
            INSERT INTO `user`(`id`, `name`, `num`, `password`, `email`, `mobile`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (1, 'admin', 'admin', '$2y$10$yD8V8Urr00CyZpmYaH7gce3jUDY/r5e7p5lyYqLpBgb7Ml8USwdd2', '', '', 1, '2019-01-31 01:14:34', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `user`(`id`, `name`, `num`, `password`, `email`, `mobile`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (2, 'user', 'user', '$2y$10$yD8V8Urr00CyZpmYaH7gce3jUDY/r5e7p5lyYqLpBgb7Ml8USwdd2', '', '', 1, '2019-01-31 01:47:27', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `user`(`id`, `name`, `num`, `password`, `email`, `mobile`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (3, 'manager', 'manager', '$2y$10$yD8V8Urr00CyZpmYaH7gce3jUDY/r5e7p5lyYqLpBgb7Ml8USwdd2', '', '', 1, '2019-01-31 01:51:09', '2019-08-25 21:19:23', 0, 0, 0);
            EOT;

        $this->execute($sql);
    }
}
