<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class UserRole extends AbstractMigration
{
    public function up(): void
    {
        $this->struct();
        $this->seed();
    }

    public function down(): void
    {
        $this->table('user_role')->drop()->save();
    }

    private function struct(): void
    {
        $sql = <<<'EOT'
            CREATE TABLE `user_role` (
                `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
                `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
                `user_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
                `role_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '角色ID',
                `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
                `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
                `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
                `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
                `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
                `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
                PRIMARY KEY (`id`),
                UNIQUE KEY `uniq_user_role` (`platform_id`,`user_id`,`role_id`,`delete_at`) USING BTREE COMMENT '用户角色关联'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户角色关联';
            EOT;
        $this->execute($sql);
    }

    private function seed(): void
    {
        $sql = <<<'EOT'
INSERT INTO `user_role`(`id`, `platform_id`, `user_id`, `role_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7550830970540032, 100000, 4145731145437184, 4144257686306816, '2019-01-31 01:14:34', '2023-03-26 12:04:46', 0, 0, 0, 0);
INSERT INTO `user_role`(`id`, `platform_id`, `user_id`, `role_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7550830983122944, 100000, 4145731162214400, 4144257719861248, '2019-01-31 01:51:47', '2023-03-26 12:04:46', 0, 0, 0, 0);
INSERT INTO `user_role`(`id`, `platform_id`, `user_id`, `role_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7550831008288768, 100000, 4145731174797312, 4144257707278336, '2019-01-31 01:51:40', '2023-03-26 12:04:46', 0, 0, 0, 0);
EOT;
        $this->execute($sql);
    }
}
