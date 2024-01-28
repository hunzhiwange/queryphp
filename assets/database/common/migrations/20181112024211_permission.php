<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Permission extends AbstractMigration
{
    public function up(): void
    {
        $this->struct();
        $this->seed();
    }

    public function down(): void
    {
        $this->table('permission')->drop()->save();
    }

    private function struct(): void
    {
        $sql = <<<'EOT'
            CREATE TABLE `permission` (
                `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
                `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
                `parent_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '父级ID',
                `name` varchar(64) NOT NULL DEFAULT '' COMMENT '权限名字',
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
                UNIQUE KEY `uniq_name` (`platform_id`,`name`,`delete_at`) USING BTREE COMMENT '名字',
                KEY `idx_parent_id` (`parent_id`) USING BTREE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='权限';
            EOT;
        $this->execute($sql);
    }

    private function seed(): void
    {
        $sql = <<<'EOT'
INSERT INTO `permission`(`id`, `platform_id`, `parent_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4146175016046592, 100000, 0, '超级管理员', 'super_administrator', 1, '2019-01-31 01:14:34', '2023-03-17 03:33:48', 0, 0, 0, 0);
INSERT INTO `permission`(`id`, `platform_id`, `parent_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4146175032823808, 100000, 0, '权限管理分组', 'permission', 1, '2019-01-31 01:31:11', '2023-03-17 03:33:48', 0, 0, 0, 0);
INSERT INTO `permission`(`id`, `platform_id`, `parent_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4146175041212416, 100000, 4146175032823808, '用户管理', 'user_manager', 1, '2019-01-31 01:31:24', '2023-03-17 03:33:48', 0, 0, 0, 0);
INSERT INTO `permission`(`id`, `platform_id`, `parent_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4146175053795328, 100000, 4146175032823808, '角色管理', 'role_manager', 1, '2019-01-31 01:31:38', '2023-03-17 03:33:48', 0, 0, 0, 0);
INSERT INTO `permission`(`id`, `platform_id`, `parent_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4146175070572544, 100000, 4146175032823808, '权限管理', 'permission_manager', 1, '2019-01-31 01:31:51', '2023-03-17 03:33:48', 0, 0, 0, 0);
INSERT INTO `permission`(`id`, `platform_id`, `parent_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4146175078961152, 100000, 4146175032823808, '资源管理', 'resource_manager', 1, '2019-01-31 01:32:04', '2023-03-17 03:33:48', 0, 0, 0, 0);
INSERT INTO `permission`(`id`, `platform_id`, `parent_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4146175091544064, 100000, 0, '测试页面', 'test', 1, '2019-01-31 09:19:26', '2023-03-17 03:33:48', 0, 0, 0, 0);
INSERT INTO `permission`(`id`, `platform_id`, `parent_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4146175104126976, 100000, 0, '基本配置', 'base', 1, '2019-01-31 09:19:38', '2023-03-17 03:33:48', 0, 0, 0, 0);
INSERT INTO `permission`(`id`, `platform_id`, `parent_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4146175116709888, 100000, 4146175104126976, '系统配置', 'config', 1, '2019-01-31 09:20:08', '2023-03-17 03:33:48', 0, 0, 0, 0);
INSERT INTO `permission`(`id`, `platform_id`, `parent_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4146175129292800, 100000, 0, '一级菜单', 'menu', 1, '2021-01-13 15:26:49', '2023-03-17 03:33:48', 0, 0, 0, 0);
INSERT INTO `permission`(`id`, `platform_id`, `parent_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4146175141875712, 100000, 4146175129292800, '二级菜单', 'sub_index', 1, '2021-01-13 15:27:08', '2023-03-17 03:33:48', 0, 0, 0, 0);
INSERT INTO `permission`(`id`, `platform_id`, `parent_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4146175154458624, 100000, 4146175141875712, '下级菜单1', 'three1_index', 1, '2021-01-13 15:27:31', '2023-03-17 03:33:48', 0, 0, 0, 0);
INSERT INTO `permission`(`id`, `platform_id`, `parent_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4146175167041536, 100000, 4146175141875712, '下级菜单2', 'three2_index', 1, '2021-01-13 15:27:48', '2023-03-17 03:33:48', 0, 0, 0, 0);
EOT;
        $this->execute($sql);
    }
}
