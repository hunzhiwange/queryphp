<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class PrintTemplate extends AbstractMigration
{
    public function up(): void
    {
        $this->struct();
        $this->seed();
    }

    public function down(): void
    {
        $this->table('print_template')->drop()->save();
    }

    private function struct(): void
    {
        $sql = <<<'EOT'
CREATE TABLE `print_template` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
  `company_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '公司ID',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '模板名称',
  `is_default` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否为默认模板 0=否;1=是;',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '模板类型',
  `remark` varchar(50) NOT NULL DEFAULT '' COMMENT '备注',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
  `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
  `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `idx_platform_company` (`platform_id`,`company_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='打印模板';
EOT;
        $this->execute($sql);
    }

    private function seed(): void
    {
        $sql = <<<'EOT'
INSERT INTO `print_template` (`id`, `platform_id`, `company_id`, `name`, `is_default`, `type`, `remark`, `create_at`, `delete_at`, `create_account`, `version`) VALUES (39455653869260800, 100000, 100100, '默认模板', 1, 0, '', '2023-06-22 13:03:13', 0, 4145731145437184, 0);
INSERT INTO `print_template` (`id`, `platform_id`, `company_id`, `name`, `is_default`, `type`, `remark`, `create_at`, `delete_at`, `create_account`, `version`) VALUES (39455683602681856, 100000, 100100, '小票模板', 0, 0, '', '2023-06-22 13:03:20', 0, 4145731145437184, 0);
EOT;
        $this->execute($sql);
    }
}
