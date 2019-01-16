<?php

declare(strict_types=1);

/*
 * This file is part of the forcodepoem package.
 *
 * The PHP Application Created By Code Poem. <Query Yet Simple>
 * (c) 2018-2099 http://forcodepoem.com All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class App extends AbstractMigration
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
        $table = $this->table('app');
        $table->addColumn('identity', 'string', ['limit' => 64, 'comment' => '应用 ID']);
        $table->addColumn('key', 'string', ['limit' => 64, 'comment' => '应用 KEY']);
        $table->addColumn('secret', 'string', ['limit' => 64, 'comment' => '应用秘钥']);
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
        $adminApp = [
            'id'        => 1,
            'identity'  => 'admin',
            'key'       => 'B1DA4485-B49D-D8E3-0F9E-168D7605A797',
            'secret'    => '4282222',
            'status'    => '1',
        ];

        $table = $this->table('app');
        $table->insert($adminApp);
        $table->saveData();
    }
}
