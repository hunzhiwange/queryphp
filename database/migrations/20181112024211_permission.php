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
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `pid` int(11) NOT NULL COMMENT '父级 ID',
                `name` varchar(64) NOT NULL COMMENT '权限名字',
                `identity` varchar(64) NOT NULL COMMENT '唯一标识符',
                `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态 0=禁用;1=启用;',
                `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
                PRIMARY KEY (`id`),
                UNIQUE KEY `identity` (`identity`),
                KEY `pid` (`pid`)
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
            INSERT INTO `permission`(`id`, `pid`, `name`, `identity`, `status`, `create_at`) VALUES (1, 0, '超级管理员', 'SuperAdministrator', 1, '2019-01-31 01:14:34');
            INSERT INTO `permission`(`id`, `pid`, `name`, `identity`, `status`, `create_at`) VALUES (2, 0, '权限管理', 'permission', 1, '2019-01-31 01:31:11');
            INSERT INTO `permission`(`id`, `pid`, `name`, `identity`, `status`, `create_at`) VALUES (3, 2, '用户管理', 'user_manager', 1, '2019-01-31 01:31:24');
            INSERT INTO `permission`(`id`, `pid`, `name`, `identity`, `status`, `create_at`) VALUES (4, 2, '角色管理', 'role_manager', 1, '2019-01-31 01:31:38');
            INSERT INTO `permission`(`id`, `pid`, `name`, `identity`, `status`, `create_at`) VALUES (5, 2, '权限管理', 'permission_manager', 1, '2019-01-31 01:31:51');
            INSERT INTO `permission`(`id`, `pid`, `name`, `identity`, `status`, `create_at`) VALUES (6, 2, '资源管理', 'resource_manager', 1, '2019-01-31 01:32:04');
            INSERT INTO `permission`(`id`, `pid`, `name`, `identity`, `status`, `create_at`) VALUES (7, 0, '测试页面', 'test', 1, '2019-01-31 09:19:26');
            INSERT INTO `permission`(`id`, `pid`, `name`, `identity`, `status`, `create_at`) VALUES (8, 0, '基本配置', 'base', 1, '2019-01-31 09:19:38');
            INSERT INTO `permission`(`id`, `pid`, `name`, `identity`, `status`, `create_at`) VALUES (9, 8, '系统配置', 'option', 1, '2019-01-31 09:20:08');
            EOT;

        $this->execute($sql);
    }
}
