<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Copmany extends AbstractMigration
{
    public function up(): void
    {
        $this->struct();
        $this->seed();
    }

    public function down(): void
    {
        $this->table('role')->drop()->save();
    }

    private function struct(): void
    {
        $sql = <<<'EOT'
            CREATE TABLE `company` (
                `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '公司 ID',
                `num` varchar(30) NOT NULL DEFAULT '' COMMENT '编号',
                `name` varchar(50) NOT NULL DEFAULT '' COMMENT '名称',
                `full_name` char(20) NOT NULL DEFAULT '' COMMENT '公司全称',
                `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态 0=禁用;1=启用;',
                `business_license` varchar(20) NOT NULL DEFAULT '' COMMENT '营业执照号',
                `legal_person` varchar(20) NOT NULL DEFAULT '' COMMENT '法人代表',
                `legal_mobile` char(11) NOT NULL DEFAULT '' COMMENT '法人手机',
                `phone` varchar(50) NOT NULL DEFAULT '' COMMENT '联系电话',
                `fax` varchar(20) NOT NULL DEFAULT '' COMMENT '传真',
                `address` varchar(50) NOT NULL DEFAULT '' COMMENT '地区',
                `web_url` varchar(50) NOT NULL DEFAULT '' COMMENT '网站',
                `logo` varchar(200) DEFAULT '' COMMENT 'logo',
                `about` varchar(1024) NOT NULL DEFAULT '' COMMENT '介绍',
                `begin_date` date NOT NULL DEFAULT '0000-00-00' COMMENT '开通时间',
                `end_date` date NOT NULL DEFAULT '0000-00-00' COMMENT '到期时间',
                `email` varchar(30) NOT NULL DEFAULT '' COMMENT '邮箱',
                `contact` varchar(30) NOT NULL DEFAULT '' COMMENT '联系人',
                `product_version` tinyint(1) NOT NULL DEFAULT '1' COMMENT '产品版本',
                `regist_ip` char(15) NOT NULL DEFAULT '0.0.0.0' COMMENT '注册 IP 地址',
                `is_test_company` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否是测试公司 0=否;1=是;',
                `extended_product_version` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '相对于 product_version 的细分扩展版本',
                `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
                `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
                `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
                `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
                `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
                `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
            EOT;
        $this->execute($sql);
    }

    private function seed(): void
    {
        $sql = <<<'EOT'
            INSERT INTO `company`(`id`, `num`, `name`, `short_name`, `status`, `business_license`, `legal_person`, `legal_mobile`, `phone`, `fax`, `address`, `web_url`, `logo`, `about`, `begin_date`, `end_date`, `email`, `contact`, `product_version`, `regist_ip`, `is_test_company`, `extended_product_version`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (1, 'hunzhiwange', '魂之挽歌', '四川魂之挽歌信息计算公司', 1, '', '', '', '', '', '', '', '', '', '2021-08-28', '2099-08-28', '', '', 1, '0.0.0.0', 0, 1, '2021-08-28 12:51:49', '2021-08-28 13:02:50', 0, 0, 0, 0);
            EOT;
        $this->execute($sql);
    }  
}
