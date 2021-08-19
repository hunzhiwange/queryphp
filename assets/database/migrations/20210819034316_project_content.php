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
                `project_id` bigint(20) DEFAULT 0 COMMENT '项目ID',
                `project_issue_id` bigint(20) DEFAULT 0 COMMENT '问题 ID',
                `content` text DEFAULT NULL COMMENT '内容',
                `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
                `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
                `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
                `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
                `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
                `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='项目问题内容';
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
