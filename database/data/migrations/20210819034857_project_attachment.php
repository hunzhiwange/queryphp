<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class ProjectAttachment extends AbstractMigration
{
    public function up(): void
    {
        $this->struct();
        $this->seed();
    }

    public function down(): void
    {
        \App\Infra\Helper\BatchDropTable::handle($this, 'project_attachment[database_data_index]');
    }

    private function struct(): void
    {
        $sql = <<<'EOT'
            CREATE TABLE `project_attachment[database_data_index]` (
                `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
                `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
                `company_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '公司ID',
                `name` varchar(100) NOT NULL DEFAULT '' COMMENT '文件名称',
                `project_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '项目ID',
                `project_issue_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '任务ID',
                `size` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '文件大小 B',
                `ext` varchar(20) NOT NULL DEFAULT '' COMMENT '文件格式',
                `path` varchar(255) NOT NULL DEFAULT '' COMMENT '文件地址',
                `download_number` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '下载次数',
                `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
                `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
                `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
                `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
                `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
                `version` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '操作版本号',
                PRIMARY KEY (`id`),
                KEY `idx_platform_company` (`platform_id`,`company_id`,`project_issue_id`,`delete_at`,`project_id`) USING BTREE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='项目附件';
            EOT;

        \App\Infra\Helper\BatchCreateTable::handle($this, $sql);
    }

    private function seed(): void
    {
    }
}
