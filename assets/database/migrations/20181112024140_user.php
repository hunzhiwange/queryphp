<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class User extends AbstractMigration
{
    public function up(): void
    {
        $this->struct();
        $this->seed();
    }

    public function down(): void
    {
        $this->table('user')->drop()->save();
    }

    private function struct(): void
    {
        $sql = <<<'EOT'
            CREATE TABLE `user` (
                `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
                `name` varchar(64) NOT NULL DEFAULT '' COMMENT '用户名字',
                `num` varchar(64) NOT NULL DEFAULT '' COMMENT '编号',
                `password` varchar(255) NOT NULL DEFAULT '' COMMENT '密码',
                `email` varchar(100) NOT NULL DEFAULT '' COMMENT 'Email',
                `mobile` char(11) NOT NULL DEFAULT '' COMMENT '手机',
                `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态 0=禁用;1=启用;',
                `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
                `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
                `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
                `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
                `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
                `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
                PRIMARY KEY (`id`),
                UNIQUE KEY `uniq_num` (`num`,`delete_at`) USING BTREE,
                UNIQUE KEY `uniq_name` (`name`,`delete_at`) USING BTREE
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户';
            EOT;
        $this->execute($sql);
    }

    private function seed(): void
    {
        $sql = <<<'EOT'
            INSERT INTO `user`(`id`, `name`, `num`, `password`, `email`, `mobile`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (1, 'admin', 'admin', '$2y$10$yD8V8Urr00CyZpmYaH7gce3jUDY/r5e7p5lyYqLpBgb7Ml8USwdd2', '', '', 1, '2019-01-31 01:14:34', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `user`(`id`, `name`, `num`, `password`, `email`, `mobile`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (2, 'user', 'user', '$2y$10$yD8V8Urr00CyZpmYaH7gce3jUDY/r5e7p5lyYqLpBgb7Ml8USwdd2', '', '', 1, '2019-01-31 01:47:27', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `user`(`id`, `name`, `num`, `password`, `email`, `mobile`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (3, 'manager', 'manager', '$2y$10$yD8V8Urr00CyZpmYaH7gce3jUDY/r5e7p5lyYqLpBgb7Ml8USwdd2', '', '', 1, '2019-01-31 01:51:09', '2019-08-25 21:19:23', 0, 0, 0);
            EOT;
        $this->execute($sql);
    }
}
