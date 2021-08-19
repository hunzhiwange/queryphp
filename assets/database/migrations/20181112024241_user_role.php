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
                `user_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '用户 ID',
                `role_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '角色 ID',
                `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
                `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
                `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
                `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
                `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
                `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
                PRIMARY KEY (`id`),
                UNIQUE KEY `uniq_user_role` (`user_id`,`role_id`,`delete_at`) USING BTREE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户角色';
            EOT;
        $this->execute($sql);
    }

    private function seed(): void
    {
        $sql = <<<'EOT'
            INSERT INTO `user_role`(`id`, `user_id`, `role_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (1, 1, 1, '2019-01-31 01:14:34', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `user_role`(`id`, `user_id`, `role_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (2, 2, 3, '2019-01-31 01:51:47', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `user_role`(`id`, `user_id`, `role_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (3, 3, 2, '2019-01-31 01:51:40', '2019-08-25 21:19:23', 0, 0, 0);
            EOT;
        $this->execute($sql);
    }
}
