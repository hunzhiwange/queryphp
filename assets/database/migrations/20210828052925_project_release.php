<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class ProjectRelease extends AbstractMigration
{
    public function up(): void
    {
        $this->struct();
        $this->seed();
    }

    public function down(): void
    {
        $this->table('project_release')->drop()->save();
    }

    private function struct(): void
    {
        $sql = <<<'EOT'
            CREATE TABLE `project_release` (
                `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
                `name` varchar(255) NOT NULL DEFAULT '' COMMENT '发行版名称',
                `sort` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '排序(ASC)',
                `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态 0=禁用;1=启用;',
                `progress` int(5) unsigned NOT NULL DEFAULT '0' COMMENT '进度条(最大值 10000，需要除以 100 表示实际进度)',
                `project_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '项目 ID',
                `completed` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '完成状态：1=未开始;2=进行中;3=延期发布;4=已发布;',
                `completed_date` datetime NOT NULL COMMENT '完成时间',
                `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
                `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
                `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
                `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
                `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
                `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
                PRIMARY KEY (`id`),
                UNIQUE KEY `uniq_name` (`name`,`delete_at`) USING BTREE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='项目版本';
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
