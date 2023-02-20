<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class ProductCategory extends AbstractMigration
{
    public function up(): void
    {
        $this->struct();
        $this->seed();
    }

    public function down(): void
    {
        $this->table('product_category')->drop()->save();
    }

    private function struct(): void
    {
        $sql = <<<'EOT'
            CREATE TABLE `product_category` (
              `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'ID',
              `company_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '公司 ID',
              `category_id` varchar(50) NOT NULL DEFAULT '' COMMENT '商品分类编号',
              `parent_id` varchar(50) NOT NULL DEFAULT '' COMMENT '父级分类 ID',
              `name` varchar(50) NOT NULL DEFAULT '' COMMENT '商品分类名字',
              `searching` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否用于搜索过滤 0=否;1=是;',
              `sort` bigint(20) unsigned NOT NULL DEFAULT '50000' COMMENT '排序(ASC)',
              `brand_id` varchar(50) NOT NULL DEFAULT '' COMMENT '分类品牌(公司内部多个主品牌)',
              `max_order_number` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '分类最大订购数量提醒',
              `letter` char(1) NOT NULL DEFAULT '' COMMENT '首字母',
              `logo_large` varchar(255) NOT NULL DEFAULT '' COMMENT '大LOGO',
              `logo_default` varchar(255) NOT NULL DEFAULT '' COMMENT 'LOGO',
              `logo_small` varchar(255) NOT NULL DEFAULT '' COMMENT '小LOGO',
              `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
              `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
              `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
              `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
              `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
              `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
              PRIMARY KEY (`id`),
              UNIQUE KEY `uniq_id` (`category_id`,`delete_at`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品分类';
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
