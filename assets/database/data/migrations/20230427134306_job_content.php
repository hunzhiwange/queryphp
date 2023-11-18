<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class JobContent extends AbstractMigration
{
    public function up(): void
    {
        $this->struct();
        $this->seed();
    }

    public function down(): void
    {
        $this->table('job_content')->drop()->save();
    }

    private function struct(): void
    {
        $sql = <<<'EOT'
CREATE TABLE `job_content` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
  `company_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '公司ID',
  `content` mediumtext NOT NULL COMMENT '内容',
  `job_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '任务ID',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
  `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
  `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `idx_platform_company` (`platform_id`,`company_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='任务管理内容';
EOT;
        $this->execute($sql);
    }

    private function seed(): void
    {
    }
}
