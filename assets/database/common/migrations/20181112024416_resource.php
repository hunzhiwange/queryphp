<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Resource extends AbstractMigration
{
    public function up(): void
    {
        $this->struct();
        $this->seed();
    }

    public function down(): void
    {
        $this->table('resource')->drop()->save();
    }

    private function struct(): void
    {
        $sql = <<<'EOT'
            CREATE TABLE `resource` (
                `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
                `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
                `name` varchar(64) NOT NULL DEFAULT '' COMMENT '资源名字',
                `num` varchar(64) NOT NULL DEFAULT '' COMMENT '编号',
                `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态 0=禁用;1=启用;',
                `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
                `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
                `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
                `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
                `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
                `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
                PRIMARY KEY (`id`),
                UNIQUE KEY `uniq_num` (`platform_id`,`num`,`delete_at`) USING BTREE COMMENT '编号',
                UNIQUE KEY `uniq_name` (`platform_id`,`name`,`delete_at`) USING BTREE COMMENT '名字'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='资源';
            EOT;
        $this->execute($sql);
    }

    private function seed(): void
    {
        $sql = <<<'EOT'
INSERT INTO `resource`(`id`, `platform_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4145943985393664, 100000, '资源列表', 'get:resource', 1, '2018-12-08 13:00:38', '2023-03-17 03:46:43', 0, 0, 0, 0);
INSERT INTO `resource`(`id`, `platform_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4145944002170880, 100000, '权限列表', 'get:permission', 1, '2018-12-08 13:00:52', '2023-03-17 03:46:43', 0, 0, 0, 0);
INSERT INTO `resource`(`id`, `platform_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4145944014753792, 100000, '角色列表', 'get:role', 1, '2018-12-08 13:01:18', '2023-03-17 03:46:43', 0, 0, 0, 0);
INSERT INTO `resource`(`id`, `platform_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4145944027336704, 100000, '用户列表', 'get:user', 1, '2018-12-08 13:01:32', '2023-03-17 03:46:43', 0, 0, 0, 0);
INSERT INTO `resource`(`id`, `platform_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4145944039919616, 100000, '资源保存', 'post:resource', 1, '2018-12-08 13:05:31', '2023-03-17 03:46:43', 0, 0, 0, 0);
INSERT INTO `resource`(`id`, `platform_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4145944052502528, 100000, '资源更新', 'put:resource/*', 1, '2018-12-08 13:05:47', '2023-03-17 03:46:43', 0, 0, 0, 0);
INSERT INTO `resource`(`id`, `platform_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4145944065085440, 100000, '资源删除', 'delete:resource/*', 1, '2018-12-08 13:06:21', '2023-03-17 03:46:43', 0, 0, 0, 0);
INSERT INTO `resource`(`id`, `platform_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4145944077668352, 100000, '资源状态', 'post:resource/status', 1, '2018-12-08 13:07:33', '2023-03-17 03:46:43', 0, 0, 0, 0);
INSERT INTO `resource`(`id`, `platform_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4145944090251264, 100000, '权限保存', 'post:permission', 1, '2018-12-08 13:10:37', '2023-03-17 03:46:43', 0, 0, 0, 0);
INSERT INTO `resource`(`id`, `platform_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4145944102834176, 100000, '权限更新', 'put:permission/*', 1, '2018-12-08 13:10:59', '2023-03-17 03:46:43', 0, 0, 0, 0);
INSERT INTO `resource`(`id`, `platform_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4145944119611392, 100000, '权限删除', 'delete:permission/*', 1, '2018-12-08 13:11:19', '2023-03-17 03:46:43', 0, 0, 0, 0);
INSERT INTO `resource`(`id`, `platform_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4145944128000000, 100000, '权限状态', 'post:permission/status', 1, '2018-12-08 13:11:39', '2023-03-17 03:46:43', 0, 0, 0, 0);
INSERT INTO `resource`(`id`, `platform_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4145944144777216, 100000, '角色保存', 'post:role', 1, '2018-12-08 13:13:53', '2023-03-17 03:46:43', 0, 0, 0, 0);
INSERT INTO `resource`(`id`, `platform_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4145944157360128, 100000, '角色更新', 'put:role/*', 1, '2018-12-08 13:14:05', '2023-03-17 03:46:43', 0, 0, 0, 0);
INSERT INTO `resource`(`id`, `platform_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4145944169943040, 100000, '角色状态', 'post:role/status', 1, '2018-12-08 13:14:17', '2023-03-17 03:46:43', 0, 0, 0, 0);
INSERT INTO `resource`(`id`, `platform_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4145944186720256, 100000, '角色删除', 'delete:role/*', 1, '2018-12-08 13:14:42', '2023-03-17 03:46:43', 0, 0, 0, 0);
INSERT INTO `resource`(`id`, `platform_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4145944199303168, 100000, '用户保存', 'post:user', 1, '2018-12-08 13:15:56', '2023-03-17 03:46:43', 0, 0, 0, 0);
INSERT INTO `resource`(`id`, `platform_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4145944216080384, 100000, '用户更新', 'put:user/*', 1, '2018-12-08 13:16:06', '2023-03-17 03:46:43', 0, 0, 0, 0);
INSERT INTO `resource`(`id`, `platform_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4145944228663296, 100000, '用户状态', 'post:user/status', 1, '2018-12-08 13:16:16', '2023-03-17 03:46:43', 0, 0, 0, 0);
INSERT INTO `resource`(`id`, `platform_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4145944241246208, 100000, '用户删除', 'delete:user/*', 1, '2018-12-08 13:16:29', '2023-03-17 03:46:43', 0, 0, 0, 0);
INSERT INTO `resource`(`id`, `platform_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4145944253829120, 100000, '系统配置', 'get:base/get-option', 1, '2018-12-08 13:00:03', '2023-03-17 03:46:43', 0, 0, 0, 0);
INSERT INTO `resource`(`id`, `platform_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4145944266412032, 100000, '超级管理员', '*', 1, '2018-12-08 13:00:03', '2023-03-17 03:46:43', 0, 0, 0, 0);
INSERT INTO `resource`(`id`, `platform_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4145944278994944, 100000, '更新配置', 'post:base/option', 1, '2019-01-31 02:05:26', '2023-03-17 03:46:43', 0, 0, 0, 0);
INSERT INTO `resource`(`id`, `platform_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4145944295772160, 100000, '用户管理菜单', 'user_index_menu', 1, '2019-01-31 02:34:10', '2023-03-17 03:46:43', 0, 0, 0, 0);
INSERT INTO `resource`(`id`, `platform_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4145944308355072, 100000, '权限管理菜单', 'permission_index_menu', 1, '2019-01-31 02:34:34', '2023-03-17 03:46:43', 0, 0, 0, 0);
INSERT INTO `resource`(`id`, `platform_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4145944320937984, 100000, '资源管理菜单', 'resource_index_menu', 1, '2019-01-31 02:35:12', '2023-03-17 03:46:43', 0, 0, 0, 0);
INSERT INTO `resource`(`id`, `platform_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4145944333520896, 100000, '角色管理菜单', 'role_index_menu', 1, '2019-01-31 02:35:31', '2023-03-17 03:46:43', 0, 0, 0, 0);
INSERT INTO `resource`(`id`, `platform_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4145944346103808, 100000, '系统配置菜单', 'option_index_menu', 1, '2019-01-31 02:36:43', '2023-03-17 03:46:43', 0, 0, 0, 0);
INSERT INTO `resource`(`id`, `platform_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4145944358686720, 100000, '个人中心菜单', 'profile_index_menu', 1, '2019-01-31 02:37:00', '2023-03-17 03:46:43', 0, 0, 0, 0);
INSERT INTO `resource`(`id`, `platform_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4145944371269632, 100000, '基础配置一级菜单', 'base_menu', 1, '2019-01-31 02:38:12', '2023-03-17 03:46:43', 0, 0, 0, 0);
INSERT INTO `resource`(`id`, `platform_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4145944388046848, 100000, '权限管理一级菜单', 'permission_menu', 1, '2019-01-31 02:38:48', '2023-03-17 03:46:43', 0, 0, 0, 0);
INSERT INTO `resource`(`id`, `platform_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4145944400629760, 100000, '测试一级菜单', 'test_menu', 1, '2019-01-31 02:39:13', '2023-03-17 03:46:43', 0, 0, 0, 0);
INSERT INTO `resource`(`id`, `platform_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4145944413212672, 100000, '测试菜单', 'test_index_menu', 1, '2019-01-31 02:39:30', '2023-03-17 03:46:43', 0, 0, 0, 0);
INSERT INTO `resource`(`id`, `platform_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4145944425795584, 100000, '用户编辑按钮', 'user_edit_button', 1, '2019-01-30 18:35:48', '2023-03-17 03:46:43', 0, 0, 0, 0);
INSERT INTO `resource`(`id`, `platform_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4145944438378496, 100000, '用户删除按钮', 'user_delete_button', 1, '2019-01-30 18:36:04', '2023-03-17 03:46:43', 0, 0, 0, 0);
INSERT INTO `resource`(`id`, `platform_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4145944455155712, 100000, '用户新增按钮', 'user_add_button', 1, '2019-01-30 18:36:31', '2023-03-17 03:46:43', 0, 0, 0, 0);
INSERT INTO `resource`(`id`, `platform_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4145944467738624, 100000, '角色编辑按钮', 'role_edit_button', 1, '2019-01-30 18:37:14', '2023-03-17 03:46:43', 0, 0, 0, 0);
INSERT INTO `resource`(`id`, `platform_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4145944480321536, 100000, '角色授权按钮', 'role_permission_button', 1, '2019-01-30 18:37:33', '2023-03-17 03:46:43', 0, 0, 0, 0);
INSERT INTO `resource`(`id`, `platform_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4145944492904448, 100000, '角色删除按钮', 'role_delete_button', 1, '2019-01-30 18:38:22', '2023-03-17 03:46:43', 0, 0, 0, 0);
INSERT INTO `resource`(`id`, `platform_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4145944509681664, 100000, '角色新增按钮', 'role_add_button', 1, '2019-01-30 18:38:48', '2023-03-17 03:46:43', 0, 0, 0, 0);
INSERT INTO `resource`(`id`, `platform_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4145944522264576, 100000, '资源编辑按钮', 'resource_edit_button', 1, '2019-01-30 18:39:25', '2023-03-17 03:46:43', 0, 0, 0, 0);
INSERT INTO `resource`(`id`, `platform_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4145944530653184, 100000, '资源删除按钮', 'resource_delete_button', 1, '2019-01-30 18:39:39', '2023-03-17 03:46:43', 0, 0, 0, 0);
INSERT INTO `resource`(`id`, `platform_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4145944543236096, 100000, '资源新增按钮', 'resource_add_button', 1, '2019-01-30 18:40:01', '2023-03-17 03:46:43', 0, 0, 0, 0);
INSERT INTO `resource`(`id`, `platform_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4145944555819008, 100000, '权限新增按钮', 'permission_add_button', 1, '2019-01-30 18:40:41', '2023-03-17 03:46:43', 0, 0, 0, 0);
INSERT INTO `resource`(`id`, `platform_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4145944568401920, 100000, '权限编辑按钮', 'permission_edit_button', 1, '2019-01-30 18:40:57', '2023-03-17 03:46:43', 0, 0, 0, 0);
INSERT INTO `resource`(`id`, `platform_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4145944585179136, 100000, '权限资源授权按钮', 'permission_resource_button', 1, '2019-01-30 18:41:13', '2023-03-17 03:46:43', 0, 0, 0, 0);
INSERT INTO `resource`(`id`, `platform_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4145944601956352, 100000, '权限删除按钮', 'permission_delete_button', 1, '2019-01-30 18:41:29', '2023-03-17 03:46:43', 0, 0, 0, 0);
INSERT INTO `resource`(`id`, `platform_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4145944614539264, 100000, '资源状态按钮', 'resource_status_button', 1, '2019-01-30 20:40:45', '2023-03-17 03:46:43', 0, 0, 0, 0);
INSERT INTO `resource`(`id`, `platform_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4145944627122176, 100000, '角色状态按钮', 'role_status_button', 1, '2019-01-30 20:40:56', '2023-03-17 03:46:43', 0, 0, 0, 0);
INSERT INTO `resource`(`id`, `platform_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4145944643899392, 100000, '权限状态按钮', 'permission_status_button', 1, '2019-01-30 20:41:13', '2023-03-17 03:46:43', 0, 0, 0, 0);
INSERT INTO `resource`(`id`, `platform_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4145944656482304, 100000, '用户状态按钮', 'user_status_button', 1, '2019-01-30 20:41:53', '2023-03-17 03:46:43', 0, 0, 0, 0);
INSERT INTO `resource`(`id`, `platform_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4145944669065216, 100000, '角色详情', 'get:role/*', 1, '2019-01-31 09:49:07', '2023-03-17 03:46:43', 0, 0, 0, 0);
INSERT INTO `resource`(`id`, `platform_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4145944681648128, 100000, '权限详情', 'get:permission/*', 1, '2019-01-31 09:49:35', '2023-03-17 03:46:43', 0, 0, 0, 0);
INSERT INTO `resource`(`id`, `platform_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4145944694231040, 100000, '角色授权', 'post:role/permission', 1, '2019-01-31 09:51:42', '2023-03-17 03:46:43', 0, 0, 0, 0);
INSERT INTO `resource`(`id`, `platform_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4145944706813952, 100000, '权限资源授权', 'post:permission/resource', 1, '2019-01-31 09:52:12', '2023-03-17 03:46:43', 0, 0, 0, 0);
INSERT INTO `resource`(`id`, `platform_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4145944723591168, 100000, '一级菜单', 'menu_menu', 1, '2021-01-13 15:23:31', '2023-03-17 03:46:43', 0, 0, 0, 0);
INSERT INTO `resource`(`id`, `platform_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4145944736174080, 100000, '二级菜单', 'sub_index_menu', 1, '2021-01-13 15:23:56', '2023-03-17 03:46:43', 0, 0, 0, 0);
INSERT INTO `resource`(`id`, `platform_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4145944748756992, 100000, '下级菜单1', 'three1_index_menu', 1, '2021-01-13 15:24:30', '2023-03-17 03:46:43', 0, 0, 0, 0);
INSERT INTO `resource`(`id`, `platform_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4145944765534208, 100000, '下级菜单2', 'three2_index_menu', 1, '2021-01-13 15:25:07', '2023-03-17 03:46:43', 0, 0, 0, 0);
INSERT INTO `resource`(`id`, `platform_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4145944778117120, 100000, '用户角色授权按钮', 'user_role_button', 1, '2021-07-22 07:36:44', '2023-03-17 03:46:43', 0, 0, 0, 0);
INSERT INTO `resource`(`id`, `platform_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4145944790700032, 100000, '用户角色授权', 'post:user/role', 1, '2021-08-14 06:30:28', '2023-03-17 03:46:43', 0, 0, 0, 0);
EOT;
        $this->execute($sql);
    }
}
