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

class UserRole extends AbstractMigration
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
            CREATE TABLE `user_role` (
                `user_id` int(11) NOT NULL COMMENT '用户 ID',
                `role_id` int(11) NOT NULL COMMENT '角色 ID',
                `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
                PRIMARY KEY (`user_id`,`role_id`)
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
            INSERT INTO `user_role`(`user_id`, `role_id`, `create_at`) VALUES (1, 1, '2019-01-31 01:14:34');
            INSERT INTO `user_role`(`user_id`, `role_id`, `create_at`) VALUES (2, 3, '2019-01-31 01:51:47');
            INSERT INTO `user_role`(`user_id`, `role_id`, `create_at`) VALUES (3, 2, '2019-01-31 01:51:40');
            EOT;

        $this->execute($sql);
    }
}
