<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class User extends AbstractMigration
{
    public function up(): void
    {
        $this->struct();
        $this->seed();
    }

    public function down(): void
    {
        $this->table('user')->drop()->save();
    }

    private function struct(): void
    {
        $sql = <<<'EOT'
CREATE TABLE `user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '账号类型 1=员工;2=客户;3=供应商;4=联营商;',
  `sub_type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '账号子类型',
  `name` varchar(64) NOT NULL DEFAULT '' COMMENT '登陆用户',
  `full_name` varchar(100) NOT NULL DEFAULT '' COMMENT '用户完整名称',
  `short_name` varchar(50) NOT NULL DEFAULT '' COMMENT '用户简写名称',
  `num` varchar(64) NOT NULL DEFAULT '' COMMENT '编号',
  `password` varchar(255) NOT NULL DEFAULT '' COMMENT '密码',
  `email` varchar(100) NOT NULL DEFAULT '' COMMENT 'Email',
  `mobile` char(11) NOT NULL DEFAULT '' COMMENT '手机',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 0=禁用;1=启用;2:待审;',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
  `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
  `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
  `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
  `contact` varchar(30) NOT NULL DEFAULT '' COMMENT '联系人',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `phone` varchar(20) NOT NULL DEFAULT '' COMMENT '电话',
  `city_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '地址区域',
  `address` varchar(100) NOT NULL DEFAULT '' COMMENT '联系地址',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_num` (`platform_id`,`num`,`delete_at`,`type`) USING BTREE COMMENT '编号',
  UNIQUE KEY `uniq_name` (`platform_id`,`name`,`delete_at`,`type`) USING BTREE COMMENT '登陆用户'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户';
EOT;
        $this->execute($sql);
    }

    private function seed(): void
    {
        $sql = <<<'EOT'
INSERT INTO `user`(`id`, `platform_id`, `type`, `sub_type`, `name`, `full_name`, `short_name`, `num`, `password`, `email`, `mobile`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `contact`, `remark`, `phone`, `city_id`, `address`) VALUES (4145731145437184, 100000, 1, 1, 'admin', '', '', 'admin', '$2y$10$yD8V8Urr00CyZpmYaH7gce3jUDY/r5e7p5lyYqLpBgb7Ml8USwdd2', '', '', 1, '2019-01-31 01:14:34', '2023-03-26 11:53:51', 0, 0, 0, 0, '', '', '', 0, '');
INSERT INTO `user`(`id`, `platform_id`, `type`, `sub_type`, `name`, `full_name`, `short_name`, `num`, `password`, `email`, `mobile`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `contact`, `remark`, `phone`, `city_id`, `address`) VALUES (4145731162214400, 100000, 1, 1, 'user', '', '', 'user', '$2y$10$yD8V8Urr00CyZpmYaH7gce3jUDY/r5e7p5lyYqLpBgb7Ml8USwdd2', '', '', 1, '2019-01-31 01:47:27', '2023-03-26 11:53:52', 0, 0, 0, 0, '', '', '', 0, '');
INSERT INTO `user`(`id`, `platform_id`, `type`, `sub_type`, `name`, `full_name`, `short_name`, `num`, `password`, `email`, `mobile`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `contact`, `remark`, `phone`, `city_id`, `address`) VALUES (4145731174797312, 100000, 1, 1, 'manager', '', '', 'manager', '$2y$10$yD8V8Urr00CyZpmYaH7gce3jUDY/r5e7p5lyYqLpBgb7Ml8USwdd2', '', '', 1, '2019-01-31 01:51:09', '2023-03-26 11:53:53', 0, 0, 0, 0, '', '', '', 0, '');
INSERT INTO `user`(`id`, `platform_id`, `type`, `sub_type`, `name`, `full_name`, `short_name`, `num`, `password`, `email`, `mobile`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `contact`, `remark`, `phone`, `city_id`, `address`) VALUES (4145731174797313, 100000, 2, 1, '2002032', '成都锦江区春熙路2032店', '', '2002032', '$2y$10$yD8V8Urr00CyZpmYaH7gce3jUDY/r5e7p5lyYqLpBgb7Ml8USwdd2', '', '', 1, '2023-03-20 06:35:20', '2023-03-26 11:53:53', 0, 0, 0, 0, '刘祥龙', '', '', 0, '');
INSERT INTO `user`(`id`, `platform_id`, `type`, `sub_type`, `name`, `full_name`, `short_name`, `num`, `password`, `email`, `mobile`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `contact`, `remark`, `phone`, `city_id`, `address`) VALUES (4145731174797314, 100000, 2, 1, '2005444', '成都温江区光华路5444店', '', '2005444', '$2y$10$yD8V8Urr00CyZpmYaH7gce3jUDY/r5e7p5lyYqLpBgb7Ml8USwdd2', '', '', 1, '2023-03-20 06:35:20', '2023-03-26 11:53:54', 0, 0, 0, 0, '高启强', '', '', 0, '');
INSERT INTO `user`(`id`, `platform_id`, `type`, `sub_type`, `name`, `full_name`, `short_name`, `num`, `password`, `email`, `mobile`, `status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `contact`, `remark`, `phone`, `city_id`, `address`) VALUES (4145731174797315, 100000, 2, 1, '2005244', '成都温江区慕华路5244店', '', '2005244', '$2y$10$yD8V8Urr00CyZpmYaH7gce3jUDY/r5e7p5lyYqLpBgb7Ml8USwdd2', '', '', 1, '2023-03-20 06:35:20', '2023-03-26 11:53:54', 0, 0, 0, 0, '高启盛', '', '', 0, '');
EOT;
        $this->execute($sql);
    }
}
