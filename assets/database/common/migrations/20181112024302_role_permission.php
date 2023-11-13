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
    `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
    `role_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '角色ID',
    `permission_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '权限ID',
    `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
    `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
    `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
    `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
    `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
    `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
    PRIMARY KEY (`id`),
    UNIQUE KEY `uniq_role_permission` (`platform_id`,`role_id`,`permission_id`,`delete_at`) USING BTREE COMMENT '角色权限关联'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色权限关联';
EOT;
        $this->execute($sql);
    }

    private function seed(): void
    {
        $sql = <<<'EOT'
INSERT INTO `role_permission`(`id`, `platform_id`, `role_id`, `permission_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7549899847634944, 100000, 4144257686306816, 4146175016046592, '2019-01-31 01:14:34', '2023-03-26 12:01:04', 0, 0, 0, 0);
INSERT INTO `role_permission`(`id`, `platform_id`, `role_id`, `permission_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7549899876995072, 100000, 4144257707278336, 4146175032823808, '2019-01-31 09:46:31', '2023-03-26 12:01:04', 0, 0, 0, 0);
INSERT INTO `role_permission`(`id`, `platform_id`, `role_id`, `permission_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7549899889577984, 100000, 4144257707278336, 4146175041212416, '2019-01-31 09:46:31', '2023-03-26 12:01:04', 0, 0, 0, 0);
INSERT INTO `role_permission`(`id`, `platform_id`, `role_id`, `permission_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7549899927326720, 100000, 4144257707278336, 4146175053795328, '2019-01-31 09:46:31', '2023-03-26 12:01:04', 0, 0, 0, 0);
INSERT INTO `role_permission`(`id`, `platform_id`, `role_id`, `permission_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7549899939909632, 100000, 4144257707278336, 4146175070572544, '2019-01-31 09:27:04', '2023-03-26 12:01:04', 0, 0, 0, 0);
INSERT INTO `role_permission`(`id`, `platform_id`, `role_id`, `permission_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7549899952492544, 100000, 4144257707278336, 4146175078961152, '2019-01-31 09:46:31', '2023-03-26 12:01:04', 0, 0, 0, 0);
INSERT INTO `role_permission`(`id`, `platform_id`, `role_id`, `permission_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7549899960881152, 100000, 4144257707278336, 4146175091544064, '2019-01-31 09:27:15', '2023-03-26 12:01:04', 0, 0, 0, 0);
INSERT INTO `role_permission`(`id`, `platform_id`, `role_id`, `permission_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7549899977658368, 100000, 4144257707278336, 4146175104126976, '2019-01-31 09:27:04', '2023-03-26 12:01:04', 0, 0, 0, 0);
INSERT INTO `role_permission`(`id`, `platform_id`, `role_id`, `permission_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7549899994435584, 100000, 4144257707278336, 4146175116709888, '2019-01-31 09:27:04', '2023-03-26 12:01:04', 0, 0, 0, 0);
INSERT INTO `role_permission`(`id`, `platform_id`, `role_id`, `permission_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7549900007018496, 100000, 4144257719861248, 4146175091544064, '2019-01-31 09:27:42', '2023-03-26 12:01:04', 0, 0, 0, 0);
INSERT INTO `role_permission`(`id`, `platform_id`, `role_id`, `permission_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7549900048961536, 100000, 4144257707278336, 4146175129292800, '2021-01-13 15:31:25', '2023-03-26 12:01:04', 0, 0, 0, 0);
INSERT INTO `role_permission`(`id`, `platform_id`, `role_id`, `permission_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7549900069933056, 100000, 4144257707278336, 4146175141875712, '2021-01-13 15:31:25', '2023-03-26 12:01:04', 0, 0, 0, 0);
INSERT INTO `role_permission`(`id`, `platform_id`, `role_id`, `permission_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7549900086710272, 100000, 4144257707278336, 4146175154458624, '2021-01-13 15:31:25', '2023-03-26 12:01:04', 0, 0, 0, 0);
INSERT INTO `role_permission`(`id`, `platform_id`, `role_id`, `permission_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7549900099293184, 100000, 4144257707278336, 4146175167041536, '2021-01-13 15:31:25', '2023-03-26 12:01:04', 0, 0, 0, 0);
EOT;
        $this->execute($sql);
    }
}
