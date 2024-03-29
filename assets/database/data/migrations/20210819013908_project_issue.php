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
        \App\Infra\Helper\BatchDropTable::handle($this, 'project_issue[database_data_index]');
    }

    private function struct(): void
    {
        $sql = <<<'EOT'
CREATE TABLE `project_issue[database_data_index]` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
  `company_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '公司ID',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
  `sub_title` varchar(255) NOT NULL DEFAULT '' COMMENT '子标题',
  `num` varchar(50) NOT NULL DEFAULT '' COMMENT '编号 例如 ISSUE-1101',
  `project_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '项目ID',
  `project_label_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '项目分类ID',
  `project_type_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '项目问题类型ID',
  `owner_user_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '负责人用户ID',
  `project_log_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '项目日志ID',
  `desc` varchar(500) NOT NULL DEFAULT '' COMMENT '描述',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '优先级别 1~5',
  `completed` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否完成 1=未完成;2=已完成;',
  `completed_date` datetime NOT NULL DEFAULT '1000-01-01 00:00:00' COMMENT '完成时间',
  `sub_task` varchar(200) NOT NULL DEFAULT '' COMMENT '子任务列表',
  `follower` varchar(200) NOT NULL DEFAULT '' COMMENT '关注人列表',
  `file_number` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '附件数量',
  `start_date` datetime NOT NULL DEFAULT '1000-01-01 00:00:00' COMMENT '计划开始时间',
  `end_date` datetime NOT NULL DEFAULT '1000-01-01 00:00:00' COMMENT '计划结束时间',
  `archived` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否归档 1=未归档;2=已归档;',
  `archived_date` datetime NOT NULL DEFAULT '1000-01-01 00:00:00' COMMENT '归档时间',
  `sort` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '排序 DESC',
  `user_sort` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '会员自己的排序 DESC',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
  `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
  `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
  `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_num` (`platform_id`,`company_id`,`project_id`,`num`) USING BTREE,
  KEY `idx_platform_company` (`platform_id`,`company_id`,`project_id`,`delete_at`) USING BTREE,
  KEY `idx_label` (`platform_id`,`company_id`,`project_label_id`,`delete_at`) USING BTREE,
  KEY `idx_type` (`platform_id`,`company_id`,`project_type_id`,`delete_at`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='项目问题';
EOT;

        \App\Infra\Helper\BatchCreateTable::handle($this, $sql);
    }

    private function seed(): void
    {
    }
}
