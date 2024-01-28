<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Config extends AbstractMigration
{
    public function up(): void
    {
        $this->struct();
        $this->seed();
    }

    public function down(): void
    {
        $this->table('config')->drop()->save();
    }

    private function struct(): void
    {
        $sql = <<<'EOT'
            CREATE TABLE `config` (
                `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
                `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
                `company_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '公司ID',
                `name` varchar(200) NOT NULL DEFAULT '' COMMENT '配置名',
                `value` text NOT NULL COMMENT '配置值',
                `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
                `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
                `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
                `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
                `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
                `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
                PRIMARY KEY (`id`),
                UNIQUE KEY `uniq_name` (`platform_id`,`company_id`,`name`,`delete_at`) USING BTREE COMMENT '配置名'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统配置';
            EOT;
        $this->execute($sql);
    }

    private function seed(): void
    {
        $sql = <<<'EOT'
INSERT INTO `config`(`id`, `platform_id`, `company_id`, `name`, `value`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7550607258947584, 100000, 100100, 'site_status', '1', '2019-04-14 22:26:25', '2023-03-26 12:45:14', 0, 0, 0, 0);
INSERT INTO `config`(`id`, `platform_id`, `company_id`, `name`, `value`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7550607279919104, 100000, 100100, 'site_name', 'QueryPHP', '2019-04-14 22:26:25', '2023-03-26 12:45:15', 0, 0, 0, 0);
INSERT INTO `config`(`id`, `platform_id`, `company_id`, `name`, `value`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7550607305084928, 100000, 100100, 'site_json', '{\"hello\":\"world\"}', '2022-12-16 10:38:11', '2023-03-26 12:45:16', 0, 0, 0, 0);
EOT;
        $this->execute($sql);
    }
}
