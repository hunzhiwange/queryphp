<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Option extends AbstractMigration
{
    public function up(): void
    {
        $this->struct();
        $this->seed();
    }

    public function down(): void
    {
        $this->table('option')->drop()->save();
    }

    private function struct(): void
    {
        $sql = <<<'EOT'
            CREATE TABLE `option` (
                `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
                `name` varchar(200) NOT NULL DEFAULT '' COMMENT '配置名',
                `value` text NOT NULL COMMENT '配置值',
                `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
                `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
                `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
                `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
                `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
                `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
                PRIMARY KEY (`id`),
                UNIQUE KEY `uniq_name` (`name`,`delete_at`) USING BTREE
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统配置';
            EOT;
        $this->execute($sql);
    }

    private function seed(): void
    {
        $sql = <<<'EOT'
            INSERT INTO `option`(`id`, `name`, `value`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (1, 'site_close', '1', '2019-04-14 22:26:25', '2019-08-25 21:19:23', 0, 0, 0);
            INSERT INTO `option`(`id`, `name`, `value`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`) VALUES (2, 'site_name', 'QueryPHP', '2019-04-14 22:26:25', '2019-08-25 21:19:23', 0, 0, 0);
            EOT;
        $this->execute($sql);
    }
}
