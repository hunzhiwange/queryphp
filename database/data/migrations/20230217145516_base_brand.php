<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class BaseBrand extends AbstractMigration
{
    public function up(): void
    {
        $this->struct();
        $this->seed();
    }

    public function down(): void
    {
        $this->table('base_brand')->drop()->save();
    }

    private function struct(): void
    {
        $sql = <<<'EOT'
            CREATE TABLE `base_brand` (
              `brand_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
              `company_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '公司ID',
              `status` enum('T','F') NOT NULL DEFAULT 'T' COMMENT '状态',
              `order_num` bigint(20) unsigned NOT NULL DEFAULT '500' COMMENT '排序 DESC',
              `brand_num` varchar(30) NOT NULL DEFAULT '' COMMENT '编号',
              `brand_name` varchar(30) NOT NULL DEFAULT '' COMMENT '名称',
              `brand_logo` varchar(130) NOT NULL DEFAULT '' COMMENT 'LOGO',
              `brand_about` text COMMENT '介绍',
              `update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
              `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
              `brand_letter` varchar(30) NOT NULL DEFAULT '' COMMENT '品牌首字母',
              `seo_keywords` varchar(30) NOT NULL DEFAULT '' COMMENT 'SEO关键字',
              PRIMARY KEY (`brand_id`) USING BTREE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品品牌';
            EOT;
        $this->execute($sql);
    }

    private function seed(): void
    {
    }
}
