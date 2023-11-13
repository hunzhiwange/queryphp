<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Role extends AbstractMigration
{
    public function up(): void
    {
        $this->struct();
        $this->seed();
    }

    public function down(): void
    {
        $this->table('role')->drop()->save();
    }

    private function struct(): void
    {
        $sql = <<<'EOT'
            CREATE TABLE `role` (
                `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
                `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
                `name` varchar(64) NOT NULL DEFAULT '' COMMENT '角色名字',
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
                UNIQUE KEY `uniq_name` (`platform_id`,`name`,`delete_at`) USING BTREE COMMENT '角色名字'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色';
            EOT;
        $this->execute($sql);
    }

    private function seed(): void
    {
        $sql = <<<'EOT'
INSERT INTO `role`(`id`, `platform_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4144257686306816, 100000, '超级管理员', 'superAdministrator', 1, '2019-01-31 01:14:34', '2023-03-17 03:46:27', 0, 0, 0, 0);
INSERT INTO `role`(`id`, `platform_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4144257707278336, 100000, '管理员', 'admin', 1, '2019-01-31 01:49:49', '2023-03-17 03:46:27', 0, 0, 0, 0);
INSERT INTO `role`(`id`, `platform_id`, `name`, `num`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4144257719861248, 100000, '会员', 'vip', 1, '2019-01-31 01:49:56', '2023-03-17 03:46:27', 0, 0, 0, 0);
EOT;
        $this->execute($sql);
    }
}
