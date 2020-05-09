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

class Permission extends AbstractMigration
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
            CREATE TABLE `permission` (
                `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
                `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父级 ID',
                `name` varchar(64) NOT NULL DEFAULT '' COMMENT '权限名字',
                `num` varchar(64) NOT NULL DEFAULT '' COMMENT '编号',
                `status` tinyint(4) unsigned NOT NULL DEFAULT '1' COMMENT '状态 0=禁用;1=启用;',
                `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
                `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
                `delete_at` bigint(20)  unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
                `create_account` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
                `update_account` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
                `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
                PRIMARY KEY (`id`),
                UNIQUE KEY `num` (`num`,`delete_at`),
                KEY `pid` (`pid`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='权限';
            EOT;

        $this->execute($sql);
    }

    /**
     * seed.
     */
    private function seed(): void
    {
        $sql = <<<'EOT'
            INSERT INTO `permission`(`id`, `pid`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (1, 0, '超级管理员', 'SuperAdministrator', 1, '2019-01-31 01:14:34', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `permission`(`id`, `pid`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (2, 0, '权限管理', 'permission', 1, '2019-01-31 01:31:11', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `permission`(`id`, `pid`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (3, 2, '用户管理', 'user_manager', 1, '2019-01-31 01:31:24', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `permission`(`id`, `pid`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (4, 2, '角色管理', 'role_manager', 1, '2019-01-31 01:31:38', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `permission`(`id`, `pid`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (5, 2, '权限管理', 'permission_manager', 1, '2019-01-31 01:31:51', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `permission`(`id`, `pid`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (6, 2, '资源管理', 'resource_manager', 1, '2019-01-31 01:32:04', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `permission`(`id`, `pid`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (7, 0, '测试页面', 'test', 1, '2019-01-31 09:19:26', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `permission`(`id`, `pid`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (8, 0, '基本配置', 'base', 1, '2019-01-31 09:19:38', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `permission`(`id`, `pid`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (9, 8, '系统配置', 'option', 1, '2019-01-31 09:20:08', '2019-08-25 21:19:23', 0, 0, 0);
            EOT;

        $this->execute($sql);
    }
}
