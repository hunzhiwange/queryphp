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
INSERT INTO `resource`(`id`, `name`, `identity`, `status`, `create_at`) VALUES (2, '资源列表', 'get:resource', 1, '2018-12-08 13:00:38');
INSERT INTO `resource`(`id`, `name`, `identity`, `status`, `create_at`) VALUES (3, '权限列表', 'get:permission', 1, '2018-12-08 13:00:52');
INSERT INTO `resource`(`id`, `name`, `identity`, `status`, `create_at`) VALUES (4, '角色列表', 'get:role', 1, '2018-12-08 13:01:18');
INSERT INTO `resource`(`id`, `name`, `identity`, `status`, `create_at`) VALUES (5, '用户列表', 'get:user', 1, '2018-12-08 13:01:32');
INSERT INTO `resource`(`id`, `name`, `identity`, `status`, `create_at`) VALUES (7, '资源保存', 'post:resource', 1, '2018-12-08 13:05:31');
INSERT INTO `resource`(`id`, `name`, `identity`, `status`, `create_at`) VALUES (8, '资源更新', 'put:resource/*', 1, '2018-12-08 13:05:47');
INSERT INTO `resource`(`id`, `name`, `identity`, `status`, `create_at`) VALUES (9, '资源删除', 'delete:resource/*', 1, '2018-12-08 13:06:21');
INSERT INTO `resource`(`id`, `name`, `identity`, `status`, `create_at`) VALUES (10, '资源状态', 'post:resource/status', 1, '2018-12-08 13:07:33');
INSERT INTO `resource`(`id`, `name`, `identity`, `status`, `create_at`) VALUES (11, '权限保存', 'post:permission', 1, '2018-12-08 13:10:37');
INSERT INTO `resource`(`id`, `name`, `identity`, `status`, `create_at`) VALUES (12, '权限更新', 'put:permission/*', 1, '2018-12-08 13:10:59');
INSERT INTO `resource`(`id`, `name`, `identity`, `status`, `create_at`) VALUES (13, '权限删除', 'delete:permission/*', 1, '2018-12-08 13:11:19');
INSERT INTO `resource`(`id`, `name`, `identity`, `status`, `create_at`) VALUES (14, '权限状态', 'post:permission/status', 1, '2018-12-08 13:11:39');
INSERT INTO `resource`(`id`, `name`, `identity`, `status`, `create_at`) VALUES (15, '角色保存', 'post:role', 1, '2018-12-08 13:13:53');
INSERT INTO `resource`(`id`, `name`, `identity`, `status`, `create_at`) VALUES (16, '角色更新', 'put:role/*', 1, '2018-12-08 13:14:05');
INSERT INTO `resource`(`id`, `name`, `identity`, `status`, `create_at`) VALUES (17, '角色状态', 'post:role/status', 1, '2018-12-08 13:14:17');
INSERT INTO `resource`(`id`, `name`, `identity`, `status`, `create_at`) VALUES (18, '角色删除', 'delete:role/*', 1, '2018-12-08 13:14:42');
INSERT INTO `resource`(`id`, `name`, `identity`, `status`, `create_at`) VALUES (19, '用户保存', 'post:user', 1, '2018-12-08 13:15:56');
INSERT INTO `resource`(`id`, `name`, `identity`, `status`, `create_at`) VALUES (20, '用户更新', 'put:user/*', 1, '2018-12-08 13:16:06');
INSERT INTO `resource`(`id`, `name`, `identity`, `status`, `create_at`) VALUES (21, '用户状态', 'post:user/status', 1, '2018-12-08 13:16:16');
INSERT INTO `resource`(`id`, `name`, `identity`, `status`, `create_at`) VALUES (22, '用户删除', 'delete:user/*', 1, '2018-12-08 13:16:29');
INSERT INTO `resource`(`id`, `name`, `identity`, `status`, `create_at`) VALUES (25, '系统配置', 'get:base/get-option', 1, '2018-12-08 13:00:03');
INSERT INTO `resource`(`id`, `name`, `identity`, `status`, `create_at`) VALUES (26, '超级管理员', '*', 1, '2018-12-08 13:00:03');
INSERT INTO `resource`(`id`, `name`, `identity`, `status`, `create_at`) VALUES (28, '更新配置', 'post:base/option', 1, '2019-01-31 02:05:26');
INSERT INTO `resource`(`id`, `name`, `identity`, `status`, `create_at`) VALUES (29, '用户管理菜单', 'user_index_menu', 1, '2019-01-31 02:34:10');
INSERT INTO `resource`(`id`, `name`, `identity`, `status`, `create_at`) VALUES (30, '权限管理菜单', 'permission_index_menu', 1, '2019-01-31 02:34:34');
INSERT INTO `resource`(`id`, `name`, `identity`, `status`, `create_at`) VALUES (31, '资源管理菜单', 'resource_index_menu', 1, '2019-01-31 02:35:12');
INSERT INTO `resource`(`id`, `name`, `identity`, `status`, `create_at`) VALUES (32, '角色管理菜单', 'role_index_menu', 1, '2019-01-31 02:35:31');
INSERT INTO `resource`(`id`, `name`, `identity`, `status`, `create_at`) VALUES (33, '系统配置菜单', 'option_index_menu', 1, '2019-01-31 02:36:43');
INSERT INTO `resource`(`id`, `name`, `identity`, `status`, `create_at`) VALUES (34, '个人中心菜单', 'profile_index_menu', 1, '2019-01-31 02:37:00');
INSERT INTO `resource`(`id`, `name`, `identity`, `status`, `create_at`) VALUES (35, '基础配置一级菜单', 'base_menu', 1, '2019-01-31 02:38:12');
INSERT INTO `resource`(`id`, `name`, `identity`, `status`, `create_at`) VALUES (36, '权限管理一级菜单', 'permission_menu', 1, '2019-01-31 02:38:48');
INSERT INTO `resource`(`id`, `name`, `identity`, `status`, `create_at`) VALUES (37, '测试一级菜单', 'test_menu', 1, '2019-01-31 02:39:13');
INSERT INTO `resource`(`id`, `name`, `identity`, `status`, `create_at`) VALUES (38, '测试菜单', 'test_index_menu', 1, '2019-01-31 02:39:30');
INSERT INTO `resource`(`id`, `name`, `identity`, `status`, `create_at`) VALUES (40, '用户编辑按钮', 'user_edit_button', 1, '2019-01-30 18:35:48');
INSERT INTO `resource`(`id`, `name`, `identity`, `status`, `create_at`) VALUES (41, '用户删除按钮', 'user_delete_button', 1, '2019-01-30 18:36:04');
INSERT INTO `resource`(`id`, `name`, `identity`, `status`, `create_at`) VALUES (42, '用户新增按钮', 'user_add_button', 1, '2019-01-30 18:36:31');
INSERT INTO `resource`(`id`, `name`, `identity`, `status`, `create_at`) VALUES (43, '角色编辑按钮', 'role_edit_button', 1, '2019-01-30 18:37:14');
INSERT INTO `resource`(`id`, `name`, `identity`, `status`, `create_at`) VALUES (44, '角色授权按钮', 'role_permission_button', 1, '2019-01-30 18:37:33');
INSERT INTO `resource`(`id`, `name`, `identity`, `status`, `create_at`) VALUES (45, '角色删除按钮', 'role_delete_button', 1, '2019-01-30 18:38:22');
INSERT INTO `resource`(`id`, `name`, `identity`, `status`, `create_at`) VALUES (46, '角色新增按钮', 'role_add_button', 1, '2019-01-30 18:38:48');
INSERT INTO `resource`(`id`, `name`, `identity`, `status`, `create_at`) VALUES (47, '资源编辑按钮', 'resource_edit_button', 1, '2019-01-30 18:39:25');
INSERT INTO `resource`(`id`, `name`, `identity`, `status`, `create_at`) VALUES (48, '资源删除按钮', 'resource_delete_button', 1, '2019-01-30 18:39:39');
INSERT INTO `resource`(`id`, `name`, `identity`, `status`, `create_at`) VALUES (49, '资源新增按钮', 'resource_add_button', 1, '2019-01-30 18:40:01');
INSERT INTO `resource`(`id`, `name`, `identity`, `status`, `create_at`) VALUES (50, '权限新增按钮', 'permission_add_button', 1, '2019-01-30 18:40:41');
INSERT INTO `resource`(`id`, `name`, `identity`, `status`, `create_at`) VALUES (51, '权限编辑按钮', 'permission_edit_button', 1, '2019-01-30 18:40:57');
INSERT INTO `resource`(`id`, `name`, `identity`, `status`, `create_at`) VALUES (52, '权限资源授权按钮', 'permission_resource_button', 1, '2019-01-30 18:41:13');
INSERT INTO `resource`(`id`, `name`, `identity`, `status`, `create_at`) VALUES (53, '权限删除按钮', 'permission_delete_button', 1, '2019-01-30 18:41:29');
INSERT INTO `resource`(`id`, `name`, `identity`, `status`, `create_at`) VALUES (54, '资源状态按钮', 'resource_status_button', 1, '2019-01-30 20:40:45');
INSERT INTO `resource`(`id`, `name`, `identity`, `status`, `create_at`) VALUES (55, '角色状态按钮', 'role_status_button', 1, '2019-01-30 20:40:56');
INSERT INTO `resource`(`id`, `name`, `identity`, `status`, `create_at`) VALUES (56, '权限状态按钮', 'permission_status_button', 1, '2019-01-30 20:41:13');
INSERT INTO `resource`(`id`, `name`, `identity`, `status`, `create_at`) VALUES (57, '用户状态按钮', 'user_status_button', 1, '2019-01-30 20:41:53');
INSERT INTO `resource`(`id`, `name`, `identity`, `status`, `create_at`) VALUES (58, '角色详情', 'get:role/*', 1, '2019-01-31 09:49:07');
INSERT INTO `resource`(`id`, `name`, `identity`, `status`, `create_at`) VALUES (59, '权限详情', 'get:permission/*', 1, '2019-01-31 09:49:35');
INSERT INTO `resource`(`id`, `name`, `identity`, `status`, `create_at`) VALUES (60, '角色授权', 'post:role/permission', 1, '2019-01-31 09:51:42');
INSERT INTO `resource`(`id`, `name`, `identity`, `status`, `create_at`) VALUES (61, '权限资源授权', 'post:permission/resource', 1, '2019-01-31 09:52:12');
EOT;

        $this->execute($sql);
    }
}
