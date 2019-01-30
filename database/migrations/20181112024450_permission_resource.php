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

use Phinx\Migration\AbstractMigration;

class PermissionResource extends AbstractMigration
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
        $table = $this->table('permission_resource', ['id' => false, 'primary_key' => ['permission_id', 'resource_id']]);
        $table->addColumn('permission_id', 'integer', ['limit' => 11, 'comment' => '权限 ID']);
        $table->addColumn('resource_id', 'integer', ['limit' => 11, 'comment' => '资源 ID']);
        $table->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'comment' => '创建时间']);
        $table->create();

        // 初始化数据
        $this->seed();
    }

    /**
     * 初始化数据.
     */
    private function seed()
    {
        $premissionResource = [
            'permission_id'       => 1,
            'resource_id'         => 26,
        ];

        $table = $this->table('permission_resource');
        $table->insert($premissionResource);
        $table->saveData();
    }
}
