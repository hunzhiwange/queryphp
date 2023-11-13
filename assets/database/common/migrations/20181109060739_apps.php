<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Apps extends AbstractMigration
{
    public function up(): void
    {
        $this->struct();
        $this->seed();
    }

    public function down(): void
    {
        $this->table('app')->drop()->save();
    }

    private function struct(): void
    {
        $sql = <<<'EOT'
            CREATE TABLE `app` (
                `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
                `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
                `num` varchar(64) NOT NULL DEFAULT '' COMMENT '应用ID',
                `key` varchar(64) NOT NULL DEFAULT '' COMMENT '应用KEY',
                `secret` varchar(64) NOT NULL DEFAULT '' COMMENT '应用秘钥',
                `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态 0=禁用;1=启用;',
                `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
                `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
                `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
                `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
                `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
                `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
                PRIMARY KEY (`id`),
                UNIQUE KEY `uniq_num` (`platform_id`,`num`,`delete_at`) USING BTREE COMMENT '应用ID',
                UNIQUE KEY `uniq_key` (`platform_id`,`key`,`delete_at`) USING BTREE COMMENT '应用KEY'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='应用';
            EOT;
        $this->execute($sql);
    }

    private function seed(): void
    {
        $sql = <<<'EOT'
            INSERT INTO `app`(`id`, `platform_id`, `num`, `key`, `secret`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7550183223201792, 100000, 'admin', '785436', 'Wb9KITjDkv', 1, '2019-04-14 22:26:25', '2023-03-26 12:05:28', 0, 0, 0, 0);
            EOT;
        $this->execute($sql);
    }
}
