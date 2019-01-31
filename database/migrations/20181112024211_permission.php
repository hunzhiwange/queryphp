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

use Phinx\Db\Adapter\MysqlAdapter;
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
    public function change()
    {
        $table = $this->table('permission');
        $table->addColumn('pid', 'integer', ['limit' => 11, 'comment' => '父级 ID']);
        $table->addColumn('name', 'string', ['limit' => 64, 'comment' => '权限名字']);
        $table->addColumn('identity', 'string', ['limit' => 64, 'comment' => '唯一标识符']);
        $table->addColumn('status', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'default' => '1', 'comment' => '状态 0=禁用;1=启用;']);
        $table->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'comment' => '创建时间']);
        $table->addIndex('identity', ['unique' => true]);
        $table->addIndex('pid');
        $table->create();

        // 初始化数据
        $this->seed();
    }

    /**
     * 初始化数据.
     */
    private function seed()
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
