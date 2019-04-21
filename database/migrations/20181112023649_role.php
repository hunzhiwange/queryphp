<?php

declare(strict_types=1);

/*
 * This file is part of the your app package.
 *
 * The PHP Application For Code Poem For You.
 * (c) 2018-2099 http://yourdomian.com All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Phinx\Migration\AbstractMigration;

class Role extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $this->struct();
        $this->seed();
    }

    /**
     * struct.
     */
    private function struct(): void
    {
        $sql = <<<'EOT'
            CREATE TABLE `role` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `name` varchar(64) NOT NULL COMMENT '角色名字',
                `identity` varchar(64) NOT NULL COMMENT '唯一标识符',
                `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态 0=禁用;1=启用;',
                `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
                PRIMARY KEY (`id`),
                UNIQUE KEY `identity` (`identity`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
            EOT;

        $this->execute($sql);
    }

    /**
     * seed.
     */
    private function seed(): void
    {
        $sql = <<<'EOT'
            INSERT INTO `role`(`id`, `name`, `identity`, `status`, `create_at`) VALUES (1, '超级管理员', 'SuperAdministrator', 1, '2019-01-31 01:14:34');
            INSERT INTO `role`(`id`, `name`, `identity`, `status`, `create_at`) VALUES (2, '管理员', 'admin', 1, '2019-01-31 01:49:49');
            INSERT INTO `role`(`id`, `name`, `identity`, `status`, `create_at`) VALUES (3, '会员', 'vip', 1, '2019-01-31 01:49:56');
            EOT;

        $this->execute($sql);
    }
}
