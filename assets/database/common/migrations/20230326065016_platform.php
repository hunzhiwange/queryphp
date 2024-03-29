<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Platform extends AbstractMigration
{
    public function up(): void
    {
        $this->struct();
        $this->seed();
    }

    public function down(): void
    {
        $this->table('platform')->drop()->save();
    }

    private function struct(): void
    {
        $sql = <<<'EOT'
CREATE TABLE `platform` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '平台ID',
  `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台编号 自增ID+3位数据库+2位表名',
  `num` varchar(30) NOT NULL DEFAULT '' COMMENT '编号',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '名称',
  `full_name` char(100) NOT NULL DEFAULT '' COMMENT '平台全称',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态 0=禁用;1=启用;',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
  `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
  `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
  `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_platform_id` (`platform_id`) USING BTREE COMMENT '平台编号'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='平台';
EOT;
        $this->execute($sql);
    }

    private function seed(): void
    {
        $sql = <<<'EOT'
INSERT INTO `platform`(`id`, `platform_id`, `num`, `name`, `full_name`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7550678834745344, 100000, 'jrdh', '今日订货', '今日订货平台', 1, '2023-03-26 04:29:12', '2023-03-26 04:32:11', 0, 0, 0, 0);
EOT;
        $this->execute($sql);
    }
}
