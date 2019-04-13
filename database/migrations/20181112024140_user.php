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

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class User extends AbstractMigration
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
    public function change()
    {
        $table = $this->table('user');
        $table->addColumn('name', 'string', ['limit' => 64, 'comment' => '用户名字']);
        $table->addColumn('identity', 'string', ['limit' => 64, 'comment' => '唯一标识符']);
        $table->addColumn('password', 'string', ['limit' => 255, 'comment' => '密码']);
        $table->addColumn('email', 'string', ['limit' => 100, 'comment' => 'Email']);
        $table->addColumn('mobile', 'char', ['limit' => 11, 'comment' => '手机']);
        $table->addColumn('status', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'default' => '1', 'comment' => '状态 0=禁用;1=启用;']);
        $table->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'comment' => '创建时间']);
        $table->addIndex('identity', ['unique' => true]);
        $table->create();

        // 初始化数据
        $this->seed();
    }

    /**
     * 初始化数据.
     */
    private function seed()
    {
        $sql = <<<'EOT'
            INSERT INTO `user`(`id`, `name`, `identity`, `password`, `email`, `mobile`, `status`, `create_at`) VALUES (1, 'admin', 'admin', '$2y$10$yD8V8Urr00CyZpmYaH7gce3jUDY/r5e7p5lyYqLpBgb7Ml8USwdd2', '', '', 1, '2019-01-31 01:14:34');
            INSERT INTO `user`(`id`, `name`, `identity`, `password`, `email`, `mobile`, `status`, `create_at`) VALUES (2, 'user', 'user', '$2y$10$yD8V8Urr00CyZpmYaH7gce3jUDY/r5e7p5lyYqLpBgb7Ml8USwdd2', '', '', 1, '2019-01-31 01:47:27');
            INSERT INTO `user`(`id`, `name`, `identity`, `password`, `email`, `mobile`, `status`, `create_at`) VALUES (3, 'manager', 'manager', '$2y$10$yD8V8Urr00CyZpmYaH7gce3jUDY/r5e7p5lyYqLpBgb7Ml8USwdd2', '', '', 1, '2019-01-31 01:51:09');
            EOT;

        $this->execute($sql);
    }
}
