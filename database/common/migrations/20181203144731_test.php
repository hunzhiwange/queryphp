<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Test extends AbstractMigration
{
    public function up(): void
    {
        $this->struct();
        $this->seed();
    }

    public function down(): void
    {
        $this->table('test')->drop()->save();
    }

    private function struct(): void
    {
        $sql = <<<'EOT'
            CREATE TABLE `test` (
              `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
              `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
              `name` varchar(200) NOT NULL DEFAULT '' COMMENT '测试名',
              `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
              `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
              `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
              `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
              `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
              `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
              PRIMARY KEY (`id`),
              KEY `idx_delete_at` (`platform_id`,`delete_at`) USING BTREE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='测试';
            EOT;
        $this->execute($sql);
    }

    private function seed(): void
    {
        $sql = <<<'EOT'
INSERT INTO `test`(`id`, `platform_id`, `name`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7550760971800576, 100000, 'foo', '2019-08-25 21:19:23', '2023-03-26 12:48:35', 0, 0, 0, 0);
INSERT INTO `test`(`id`, `platform_id`, `name`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7550760988577792, 100000, 'bar', '2019-08-25 21:19:23', '2023-03-26 12:48:35', 0, 0, 0, 0);
EOT;
        $this->execute($sql);
    }
}
