<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class ProjectIssue extends AbstractMigration
{
    public function up(): void
    {
        $this->struct();
        $this->seed();
    }

    public function down(): void
    {
        $this->table('project_issue')->drop()->save();
    }

    private function struct(): void
    {
        $sql = <<<'EOT'
            CREATE TABLE `project_issue` (
                `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
                `project_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '项目ID',
                `project_label_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '项目分类 ID',
                `project_type_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '项目问题类型 ID',
                `owner_user_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '负责人用户 ID',
                `title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
                `desc` varchar(500) NOT NULL DEFAULT '' COMMENT '描述',
                `level` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '优先级别：1~4',
                `completed` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否完成：1=未完成;2=已完成;',
                `completed_date` datetime NOT NULL COMMENT '创建时间',
                `sub_task` text NOT NULL COMMENT '子任务列表',
                `follower` text NOT NULL COMMENT '关注人列表',
                `push_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '已发送的最后动态 ID',
                `file_number` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '附件数量',
                `start_date` datetime NOT NULL COMMENT '计划开始时间',
                `end_date` datetime NOT NULL COMMENT '计划结束时间',
                `archived` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否归档：1=未归档;2=已归档;',
                `archived_date` datetime NOT NULL COMMENT '归档时间',
                `sort` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '排序(DESC)',
                `user_sort` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '会员自己的排序(DESC)',
                `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
                `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
                `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
                `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
                `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
                `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='项目问题';
            EOT;
        $this->execute($sql);
    }

    private function seed(): void
    {
        return;
        /*
        $sql = <<<'EOT'
            EOT;
        $this->execute($sql);
        */
    }
}
