<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Project extends AbstractMigration
{
    public function up(): void
    {
        $this->struct();
        $this->seed();
    }

    public function down(): void
    {
        $this->table('project')->drop()->save();
    }

    private function struct(): void
    {
        $sql = <<<'EOT'
            CREATE TABLE `project` (
                `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
                `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
                `company_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '公司ID',
                `name` varchar(255) NOT NULL DEFAULT '' COMMENT '项目名称',
                `num` varchar(64) NOT NULL DEFAULT '' COMMENT '编号',
                `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态 0=禁用;1=启用;',
                `progress` int(5) unsigned NOT NULL DEFAULT '0' COMMENT '进度条 最大值 10000，需要除以 100 表示实际进度',
                `owner_user_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '项目所有者用户ID',
                `completed_number` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '已完成任务数量',
                `unfinished_number` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '未完成任务数量',
                `sort` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '排序 DESC',
                `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
                `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
                `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
                `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
                `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
                `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
                PRIMARY KEY (`id`),
                UNIQUE KEY `uniq_name` (`platform_id`,`company_id`,`name`,`delete_at`) USING BTREE,
                UNIQUE KEY `uniq_num` (`platform_id`,`company_id`,`num`,`delete_at`) USING BTREE,
                KEY `idx_platform_company` (`platform_id`,`company_id`,`status`,`delete_at`) USING BTREE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='项目';
            EOT;
        $this->execute($sql);
    }

    private function seed(): void
    {
    }
}
