<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class RolePermission extends AbstractMigration
{
    public function up(): void
    {
        $this->struct();
        $this->seed();
    }

    public function down(): void
    {
        $this->table('role_permission')->drop()->save();
    }

    private function struct(): void
    {
        $sql = <<<'EOT'
            CREATE TABLE `role_permission` (
                `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
                `role_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '角色 ID',
                `permission_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '权限 ID',
                `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
                `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
                `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
                `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
                `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
                `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
                PRIMARY KEY (`id`),
                UNIQUE KEY `uniq_role_permission` (`role_id`,`permission_id`,`delete_at`) USING BTREE
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色权限关联';
            EOT;
        $this->execute($sql);
    }

    private function seed(): void
    {
        $sql = <<<'EOT'
            INSERT INTO `role_permission`(`id`, `role_id`, `permission_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (1, 1, 1, '2019-01-31 01:14:34', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `role_permission`(`id`, `role_id`, `permission_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (2, 2, 2, '2019-01-31 09:46:31', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `role_permission`(`id`, `role_id`, `permission_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (3, 2, 3, '2019-01-31 09:46:31', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `role_permission`(`id`, `role_id`, `permission_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (4, 2, 4, '2019-01-31 09:46:31', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `role_permission`(`id`, `role_id`, `permission_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (5, 2, 5, '2019-01-31 09:27:04', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `role_permission`(`id`, `role_id`, `permission_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (6, 2, 6, '2019-01-31 09:46:31', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `role_permission`(`id`, `role_id`, `permission_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (7, 2, 7, '2019-01-31 09:27:15', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `role_permission`(`id`, `role_id`, `permission_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (8, 2, 8, '2019-01-31 09:27:04', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `role_permission`(`id`, `role_id`, `permission_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (9, 2, 9, '2019-01-31 09:27:04', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `role_permission`(`id`, `role_id`, `permission_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (10, 3, 7, '2019-01-31 09:27:42', '2019-08-25 21:19:23', 0, 0, 0);
            EOT;
        $this->execute($sql);
    }
}
