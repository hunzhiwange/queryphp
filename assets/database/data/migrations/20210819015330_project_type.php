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
                `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
                `company_id` bigint(20) unsigned NOT NULL DEFAULT '1' COMMENT '公司ID',
                `name` varchar(255) NOT NULL DEFAULT '' COMMENT '类型名称',
                `num` varchar(64) NOT NULL DEFAULT '' COMMENT '编号',
                `content_type` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '内容类型 1=BUG;2=任务;3=需求;4=故事;5=文档;6=流程图;7=思维导图;8=Swagger内容;9=Swagger网址;10=思维导图高级版;',
                `color` char(7) NOT NULL DEFAULT '' COMMENT '颜色',
                `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态 0=禁用;1=启用;',
                `sort` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '排序 DESC',
                `icon` varchar(255) NOT NULL DEFAULT '' COMMENT '类型图标',
                `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
                `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
                `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
                `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
                `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
                `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
                PRIMARY KEY (`id`),
                UNIQUE KEY `uniq_name` (`platform_id`,`company_id`,`name`,`delete_at`) USING BTREE,
                KEY `idx_project` (`platform_id`,`company_id`,`status`,`delete_at`) USING BTREE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='项目问题类型';
            EOT;
        $this->execute($sql);
    }

    private function seed(): void
    {
        $sql = <<<'EOT'
INSERT INTO `project_type`(`id`, `platform_id`, `company_id`, `name`, `num`, `content_type`, `color`, `status`, `sort`, `icon`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (1, 100000, 100100, 'BUG', 'bug', 1, '#F06292', 1, 0, 'bug', '2021-08-27 02:44:10', '2023-03-26 13:00:08', 0, 0, 0, 0);
INSERT INTO `project_type`(`id`, `platform_id`, `company_id`, `name`, `num`, `content_type`, `color`, `status`, `sort`, `icon`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (2, 100000, 100100, '任务', 'task', 2, '#00BCD4', 1, 0, 'task', '2021-08-27 02:44:22', '2023-03-26 13:00:08', 0, 0, 0, 0);
INSERT INTO `project_type`(`id`, `platform_id`, `company_id`, `name`, `num`, `content_type`, `color`, `status`, `sort`, `icon`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (3, 100000, 100100, '需求', 'product', 3, '#588BC1', 1, 0, 'product', '2021-08-27 02:44:40', '2023-03-26 13:00:08', 0, 0, 0, 0);
INSERT INTO `project_type`(`id`, `platform_id`, `company_id`, `name`, `num`, `content_type`, `color`, `status`, `sort`, `icon`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (4, 100000, 100100, '故事', 'story', 4, '#1F5287', 1, 0, 'story', '2021-08-27 02:44:44', '2023-03-26 13:00:08', 0, 0, 0, 0);
INSERT INTO `project_type`(`id`, `platform_id`, `company_id`, `name`, `num`, `content_type`, `color`, `status`, `sort`, `icon`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (5, 100000, 100100, '文档', 'doc', 5, '#2D8CF0', 1, 0, 'doc', '2021-08-27 02:57:35', '2023-03-26 13:00:08', 0, 0, 0, 0);
INSERT INTO `project_type`(`id`, `platform_id`, `company_id`, `name`, `num`, `content_type`, `color`, `status`, `sort`, `icon`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (6, 100000, 100100, '流程图', 'process', 6, '#1D35EA', 1, 0, 'process', '2021-08-31 12:16:21', '2023-03-26 13:00:08', 0, 0, 0, 0);
INSERT INTO `project_type`(`id`, `platform_id`, `company_id`, `name`, `num`, `content_type`, `color`, `status`, `sort`, `icon`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7, 100000, 100100, '思维导图', 'mind', 7, '#51B8C5', 1, 0, 'mind', '2021-08-31 12:35:33', '2023-03-26 13:00:08', 0, 0, 0, 0);
INSERT INTO `project_type`(`id`, `platform_id`, `company_id`, `name`, `num`, `content_type`, `color`, `status`, `sort`, `icon`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (8, 100000, 100100, 'Swagger内容', 'swagger', 8, '#00BCD4', 1, 0, 'swagger', '2021-08-31 12:41:57', '2023-03-26 13:00:08', 0, 0, 0, 0);
INSERT INTO `project_type`(`id`, `platform_id`, `company_id`, `name`, `num`, `content_type`, `color`, `status`, `sort`, `icon`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (9, 100000, 100100, 'Swagger网址', 'swagger_url', 9, '#F06292', 1, 0, 'swagger_url', '2021-09-01 05:34:19', '2023-03-26 13:00:08', 0, 0, 0, 0);
INSERT INTO `project_type`(`id`, `platform_id`, `company_id`, `name`, `num`, `content_type`, `color`, `status`, `sort`, `icon`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (10, 100000, 100100, '思维导图高级版', 'mindmap', 10, '#F06292', 1, 0, 'mindmap', '2021-09-01 05:34:19', '2023-03-26 13:00:08', 0, 0, 0, 0);
EOT;
        $this->execute($sql);
    }
}
