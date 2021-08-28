<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class ProjectUser extends AbstractMigration
{
    public function up(): void
    {
        $this->struct();
        $this->seed();
    }

    public function down(): void
    {
        $this->table('project_user')->drop()->save();
    }

    private function struct(): void
    {
        $sql = <<<'EOT'
            CREATE TABLE `project_user` (
                `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
                `user_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '用户 ID',
                `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '类型 1=成员;2=收藏;3=关注;',
                `extend_type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '扩展类型 1=成员;2=管理员;',
                `data_type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '数据类型 1=项目;2=问题;',
                `data_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '数据 ID',
                `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
                `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
                `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
                `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
                `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
                `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
                PRIMARY KEY (`id`),
                UNIQUE KEY `uniq_user` (`user_id`,`type`,`extend_type`,`data_type`,`data_id`,`delete_at`) USING BTREE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='项目用户';
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
