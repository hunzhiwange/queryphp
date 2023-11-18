<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class City extends AbstractMigration
{
    public function up(): void
    {
        $this->struct();
        $this->seed();
    }

    public function down(): void
    {
        $this->table('city')->drop()->save();
    }

    private function struct(): void
    {
        $sql = <<<'EOT'
CREATE TABLE `city` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `city_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '城市ID',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '省市级别 0=省;1=市;2=区;',
  `parent_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '父级ID',
  `area_code` varchar(30) NOT NULL DEFAULT '' COMMENT '区号',
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '名称',
  `merger_name` varchar(255) NOT NULL DEFAULT '' COMMENT '合并名称',
  `lng` varchar(50) NOT NULL DEFAULT '' COMMENT '经度',
  `lat` varchar(50) NOT NULL DEFAULT '' COMMENT '纬度',
  `is_show` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否展示',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
  `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
  `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
  `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='城市表';
EOT;
        $this->execute($sql);
    }

    private function seed(): void
    {
        $sql = file_get_contents(__DIR__.'/../sql/city.sql');
        $this->execute($sql);
    }
}
