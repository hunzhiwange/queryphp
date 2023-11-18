<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Job extends AbstractMigration
{
    public function up(): void
    {
        $this->struct();
        $this->seed();
    }

    public function down(): void
    {
        $this->table('job')->drop()->save();
    }

    private function struct(): void
    {
        $sql = <<<'EOT'
CREATE TABLE `job` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
  `company_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '公司ID',
  `name` varchar(200) NOT NULL DEFAULT '' COMMENT '任务名称',
  `total` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '总条数',
  `success` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '成功条数',
  `fail` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '失败条数',
  `type` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '类型',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
  `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
  `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
  `process` tinyint(3) NOT NULL DEFAULT '0' COMMENT '处理进度 0=待处理;1=处理成功;2=处理失败;',
  `error` varchar(255) NOT NULL DEFAULT '' COMMENT '错误消息',
  `customer` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '消费者',
  `retry` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '重试次数',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `idx_platform_company` (`platform_id`,`company_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='任务管理';
EOT;
        $this->execute($sql);
    }

    private function seed(): void
    {
    }
}
