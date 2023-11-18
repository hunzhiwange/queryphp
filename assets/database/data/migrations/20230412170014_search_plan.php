<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class SearchPlan extends AbstractMigration
{
    public function up(): void
    {
        $this->struct();
        $this->seed();
    }

    public function down(): void
    {
        $this->table('search_plan')->drop()->save();
    }

    private function struct(): void
    {
        $sql = <<<'EOT'
CREATE TABLE `search_plan` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
  `company_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '公司ID',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '搜索名称',
  `is_default` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否为默认搜索 0=否;1=是;',
  `plan` text NOT NULL COMMENT '计划',
  `source_type` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '来源类型',
  `remark` varchar(50) NOT NULL DEFAULT '' COMMENT '备注',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
  `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
  `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '类型 1=搜索条件;2=列配置;',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `idx_platform_company` (`platform_id`,`company_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='常用搜索';
EOT;
        $this->execute($sql);
    }

    private function seed(): void
    {
    }
}
