<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class ProductSpecGroup extends AbstractMigration
{
    public function up(): void
    {
        $this->struct();
        $this->seed();
    }

    public function down(): void
    {
        $this->table('product_spec')->drop()->save();
    }

    private function struct(): void
    {
        $sql = <<<'EOT'
            CREATE TABLE `product_spec_group` (
              `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'ID',
              `company_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '公司 ID',
              `category_id` varchar(50) NOT NULL DEFAULT '' COMMENT '商品分类编号',
              `template` varchar(50) NOT NULL DEFAULT '' COMMENT '模板分类',
              `template_name` varchar(50) NOT NULL DEFAULT '' COMMENT '模板名字',
              `group_id` varchar(50) NOT NULL DEFAULT '' COMMENT '商品规格分组编号',
              `group_name` varchar(50) NOT NULL DEFAULT '' COMMENT '商品规格分组名字',
              `group_sku_field` varchar(50) NOT NULL DEFAULT '' COMMENT '商品规格分组对应的商品存储字段',
              `group_type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '商品规格分组类型 0=SKU规格;1=SPU属性;2=基础展示类属性;3=自定义类属性;',
              `group_searching` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '商品规格分组是否支持搜索 0=否;1=是;',
              `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
              `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
              `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
              `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
              `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
              `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
              PRIMARY KEY (`id`),
              UNIQUE KEY `uniq_id` (`group_id`,`delete_at`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品规格分组';
            EOT;
        $this->execute($sql);
    }

    private function seed(): void
    {
        /*
        $sql = <<<'EOT'
            EOT;
        $this->execute($sql);
        */
    }
}
