<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class ProjectType extends AbstractMigration
{
    public function up(): void
    {
        $this->struct();
        $this->seed();
    }

    public function down(): void
    {
        $this->table('project_type')->drop()->save();
    }

    private function struct(): void
    {
        $sql = <<<'EOT'
            CREATE TABLE `project_type` (
                `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
                `company_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '公司 ID',
                `name` varchar(255) NOT NULL DEFAULT '' COMMENT '类型名称',
                `num` varchar(64) NOT NULL DEFAULT '' COMMENT '编号',
                `content_type` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '内容类型 1=BUG;2=任务;3=需求;4=故事;5=文档;6=流程图;',
                `color` char(7) NOT NULL DEFAULT '' COMMENT '颜色',
                `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态 0=禁用;1=启用;',
                `sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序(ASC)',
                `icon` varchar(255) NOT NULL DEFAULT '' COMMENT '类型图标',
                `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
                `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
                `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
                `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
                `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
                `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
                PRIMARY KEY (`id`),
                UNIQUE KEY `uniq_name` (`name`,`delete_at`,`company_id`) USING BTREE,
                KEY `idx_project` (`company_id`,`status`,`delete_at`) USING BTREE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='项目问题类型';
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
