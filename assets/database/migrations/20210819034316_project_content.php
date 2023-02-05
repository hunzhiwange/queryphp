<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class ProjectContent extends AbstractMigration
{
    public function up(): void
    {
        $this->struct();
        $this->seed();
    }

    public function down(): void
    {
        $this->table('project_content')->drop()->save();
    }

    private function struct(): void
    {
        $sql = <<<'EOT'
            CREATE TABLE `project_content` (
                `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
                `company_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '公司 ID',
                `project_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '项目ID',
                `project_issue_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '问题 ID',
                `content` longtext NOT NULL COMMENT '内容',
                `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
                `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
                `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
                `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
                `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
                `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
                PRIMARY KEY (`id`),
                KEY `idx_company` (`company_id`,`project_id`,`project_issue_id`,`delete_at`) USING BTREE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='项目问题内容';
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
