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

class Resource extends AbstractMigration
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
        $table = $this->table('resource');
        $table->addColumn('name', 'string', ['limit' => 64, 'comment' => '资源名字']);
        $table->addColumn('identity', 'string', ['limit' => 64, 'comment' => '唯一标识符']);
        $table->addColumn('status', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'default' => '1', 'comment' => '状态 0=禁用;1=启用;']);
        $table->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'comment' => '创建时间']);
        $table->addIndex('identity', ['unique' => true]);
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
INSERT INTO `resource` VALUES (1, '个人中心', 'profile_show', 1, '2018-12-08 13:00:18');
INSERT INTO `resource` VALUES (2, '资源列表', 'resource_index', 1, '2018-12-08 13:00:38');
INSERT INTO `resource` VALUES (3, '权限列表', 'permission_index', 1, '2018-12-08 13:00:52');
INSERT INTO `resource` VALUES (4, '角色列表', 'role_index', 1, '2018-12-08 13:01:18');
INSERT INTO `resource` VALUES (5, '用户列表', 'user_index', 1, '2018-12-08 13:01:32');
INSERT INTO `resource` VALUES (6, '测试页面', 'test', 1, '2018-12-08 13:04:03');
INSERT INTO `resource` VALUES (7, '资源保存', 'resource_store', 1, '2018-12-08 13:05:31');
INSERT INTO `resource` VALUES (8, '资源更新', 'resource_update', 1, '2018-12-08 13:05:47');
INSERT INTO `resource` VALUES (9, '资源删除', 'resource_destroy', 1, '2018-12-08 13:06:21');
INSERT INTO `resource` VALUES (10, '资源状态', 'resource_status', 1, '2018-12-08 13:07:33');
INSERT INTO `resource` VALUES (11, '权限保存', 'permission_store', 1, '2018-12-08 13:10:37');
INSERT INTO `resource` VALUES (12, '权限更新', 'permission_update', 1, '2018-12-08 13:10:59');
INSERT INTO `resource` VALUES (13, '权限删除', 'permission_destroy', 1, '2018-12-08 13:11:19');
INSERT INTO `resource` VALUES (14, '权限状态', 'permission_status', 1, '2018-12-08 13:11:39');
INSERT INTO `resource` VALUES (15, '角色保存', 'role_store', 1, '2018-12-08 13:13:53');
INSERT INTO `resource` VALUES (16, '角色更新', 'role_update', 1, '2018-12-08 13:14:05');
INSERT INTO `resource` VALUES (17, '角色状态', 'role_status', 1, '2018-12-08 13:14:17');
INSERT INTO `resource` VALUES (18, '角色删除', 'role_destroy', 1, '2018-12-08 13:14:42');
INSERT INTO `resource` VALUES (19, '用户保存', 'user_store', 1, '2018-12-08 13:15:56');
INSERT INTO `resource` VALUES (20, '用户更新', 'user_update', 1, '2018-12-08 13:16:06');
INSERT INTO `resource` VALUES (21, '用户状态', 'user_status', 1, '2018-12-08 13:16:16');
INSERT INTO `resource` VALUES (22, '用户删除', 'user_destroy', 1, '2018-12-08 13:16:29');
INSERT INTO `resource` VALUES (23, '更新个人资料', 'profile_update', 1, '2018-12-08 13:18:23');
INSERT INTO `resource` VALUES (24, '修改个人密码', 'profile_change_password', 1, '2018-12-08 13:19:05');
INSERT INTO `resource` VALUES (25, '系统配置', 'option', 1, '2018-12-08 13:00:03');
INSERT INTO `resource` VALUES (26, '超级管理员', '*', 1, '2018-12-08 13:00:03');
EOT;

        $this->execute($sql);
    }
}
