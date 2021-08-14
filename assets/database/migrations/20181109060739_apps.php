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
                `num` varchar(64) NOT NULL DEFAULT '' COMMENT '应用 ID',
                `key` varchar(64) NOT NULL DEFAULT '' COMMENT '应用 KEY',
                `secret` varchar(64) NOT NULL DEFAULT '' COMMENT '应用秘钥',
                `status` tinyint(4) unsigned NOT NULL DEFAULT '1' COMMENT '状态 0=禁用;1=启用;',
                `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
                `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
                `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
                `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
                `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
                `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
                PRIMARY KEY (`id`),
                UNIQUE KEY `uniq_num` (`num`,`delete_at`) USING BTREE,
                UNIQUE KEY `uniq_key` (`key`,`delete_at`) USING BTREE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='应用';
            EOT;
        $this->execute($sql);
    }

    private function seed(): void
    {
        $sql = <<<'EOT'
            INSERT INTO `app`(`id`, `num`, `key`, `secret`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (1, 'admin', 'B1DA4485-B49D-D8E3-0F9E-168D7605A797', '4282222', 1, '2019-04-14 22:26:25', '2019-08-25 21:19:23', 0, 0, 0);
            EOT;
        $this->execute($sql);
    }
}
