<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class PermissionResource extends AbstractMigration
{
    public function up(): void
    {
        $this->struct();
        $this->seed();
    }

    public function down(): void
    {
        $this->table('permission_resource')->drop()->save();
    }

    private function struct(): void
    {
        $sql = <<<'EOT'
            CREATE TABLE `permission_resource` (
                `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
                `permission_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '权限 ID',
                `resource_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '资源 ID',
                `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
                `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
                `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
                `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
                `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
                `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
                PRIMARY KEY (`id`),
                UNIQUE KEY `uniq_permission_resource` (`permission_id`,`resource_id`,`delete_at`) USING BTREE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='权限资源关联';
            EOT;
        $this->execute($sql);
    }

    private function seed(): void
    {
        $sql = <<<'EOT'
            INSERT INTO `permission_resource`(`id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (1, 1, 26, '2019-01-31 01:14:34', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `permission_resource`(`id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (2, 2, 36, '2019-01-31 09:22:11', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `permission_resource`(`id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (3, 3, 5, '2019-01-31 01:54:59', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `permission_resource`(`id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (4, 3, 19, '2019-01-31 09:23:37', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `permission_resource`(`id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (5, 3, 20, '2019-01-31 01:54:59', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `permission_resource`(`id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (6, 3, 21, '2019-01-31 09:23:37', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `permission_resource`(`id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (7, 3, 22, '2019-01-31 09:23:37', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `permission_resource`(`id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (8, 3, 29, '2019-01-31 09:23:37', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `permission_resource`(`id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (9, 3, 40, '2019-01-31 09:23:37', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `permission_resource`(`id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (10, 3, 41, '2019-01-31 09:23:37', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `permission_resource`(`id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (11, 3, 42, '2019-01-31 09:23:37', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `permission_resource`(`id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (12, 3, 57, '2019-01-31 09:23:37', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `permission_resource`(`id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (13, 4, 4, '2019-01-31 09:24:27', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `permission_resource`(`id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (14, 4, 15, '2019-01-31 09:24:27', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `permission_resource`(`id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (15, 4, 16, '2019-01-31 09:24:27', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `permission_resource`(`id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (16, 4, 17, '2019-01-31 09:24:27', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `permission_resource`(`id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (17, 4, 18, '2019-01-31 09:24:27', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `permission_resource`(`id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (18, 4, 32, '2019-01-31 09:24:27', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `permission_resource`(`id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (19, 4, 43, '2019-01-31 09:24:27', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `permission_resource`(`id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (20, 4, 44, '2019-01-31 09:24:27', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `permission_resource`(`id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (21, 4, 45, '2019-01-31 09:24:27', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `permission_resource`(`id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (22, 4, 46, '2019-01-31 09:24:27', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `permission_resource`(`id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (23, 4, 55, '2019-01-31 09:24:27', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `permission_resource`(`id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (24, 4, 58, '2019-01-31 09:50:17', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `permission_resource`(`id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (25, 4, 60, '2019-01-31 09:52:50', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `permission_resource`(`id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (26, 5, 3, '2019-01-31 09:25:04', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `permission_resource`(`id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (27, 5, 11, '2019-01-31 09:25:04', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `permission_resource`(`id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (28, 5, 12, '2019-01-31 09:25:04', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `permission_resource`(`id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (29, 5, 13, '2019-01-31 09:25:04', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `permission_resource`(`id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (30, 5, 14, '2019-01-31 09:25:04', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `permission_resource`(`id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (31, 5, 30, '2019-01-31 09:25:04', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `permission_resource`(`id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (32, 5, 36, '2019-01-31 09:25:04', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `permission_resource`(`id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (33, 5, 50, '2019-01-31 09:25:04', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `permission_resource`(`id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (34, 5, 51, '2019-01-31 09:25:04', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `permission_resource`(`id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (35, 5, 52, '2019-01-31 09:25:04', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `permission_resource`(`id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (36, 5, 53, '2019-01-31 09:25:04', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `permission_resource`(`id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (37, 5, 56, '2019-01-31 09:25:04', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `permission_resource`(`id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (38, 5, 59, '2019-01-31 09:50:30', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `permission_resource`(`id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (39, 5, 61, '2019-01-31 09:53:16', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `permission_resource`(`id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (40, 6, 2, '2019-01-31 09:25:35', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `permission_resource`(`id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (41, 6, 7, '2019-01-31 09:25:35', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `permission_resource`(`id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (42, 6, 8, '2019-01-31 09:25:35', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `permission_resource`(`id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (43, 6, 9, '2019-01-31 09:25:35', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `permission_resource`(`id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (44, 6, 10, '2019-01-31 09:25:35', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `permission_resource`(`id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (45, 6, 31, '2019-01-31 09:25:35', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `permission_resource`(`id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (46, 6, 47, '2019-01-31 09:25:35', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `permission_resource`(`id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (47, 6, 48, '2019-01-31 09:25:35', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `permission_resource`(`id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (48, 6, 49, '2019-01-31 09:25:35', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `permission_resource`(`id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (49, 6, 52, '2019-01-31 09:25:35', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `permission_resource`(`id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (50, 6, 54, '2019-01-31 09:25:35', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `permission_resource`(`id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (51, 7, 37, '2019-01-31 09:21:27', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `permission_resource`(`id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (52, 7, 38, '2019-01-31 09:21:27', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `permission_resource`(`id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (53, 8, 35, '2019-01-31 09:21:44', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `permission_resource`(`id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (54, 9, 25, '2019-01-31 09:21:55', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `permission_resource`(`id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (55, 9, 28, '2019-01-31 09:21:55', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `permission_resource`(`id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (56, 9, 33, '2019-01-31 09:21:55', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `permission_resource`(`id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (57, 13, 65, '2021-01-14 01:32:12', '2021-01-14 01:32:12', 0, 0, 0, 0);
            INSERT INTO `permission_resource`(`id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (58, 12, 64, '2021-01-14 01:31:59', '2021-01-14 01:31:59', 0, 0, 0, 0);
            INSERT INTO `permission_resource`(`id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (59, 11, 63, '2021-01-14 01:31:50', '2021-01-14 01:31:50', 0, 0, 0, 0);
            INSERT INTO `permission_resource`(`id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (60, 10, 62, '2021-01-14 01:31:40', '2021-01-14 01:31:40', 0, 0, 0, 0);
            INSERT INTO `permission_resource`(`id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (61, 3, 68, '2021-07-22 07:38:07', '2021-07-22 07:38:07', 0, 0, 0, 0);
            INSERT INTO `permission_resource`(`id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (62, 3, 69, '2021-08-14 06:30:47', '2021-08-14 06:30:47', 0, 0, 0, 0);
            EOT;
        $this->execute($sql);
    }
}
