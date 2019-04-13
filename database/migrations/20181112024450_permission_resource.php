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
        $sql = <<<'EOT'
            INSERT INTO `permission_resource`(`permission_id`, `resource_id`, `create_at`) VALUES (1, 26, '2019-01-31 01:14:34');
            INSERT INTO `permission_resource`(`permission_id`, `resource_id`, `create_at`) VALUES (2, 36, '2019-01-31 09:22:11');
            INSERT INTO `permission_resource`(`permission_id`, `resource_id`, `create_at`) VALUES (3, 5, '2019-01-31 01:54:59');
            INSERT INTO `permission_resource`(`permission_id`, `resource_id`, `create_at`) VALUES (3, 19, '2019-01-31 09:23:37');
            INSERT INTO `permission_resource`(`permission_id`, `resource_id`, `create_at`) VALUES (3, 20, '2019-01-31 01:54:59');
            INSERT INTO `permission_resource`(`permission_id`, `resource_id`, `create_at`) VALUES (3, 21, '2019-01-31 09:23:37');
            INSERT INTO `permission_resource`(`permission_id`, `resource_id`, `create_at`) VALUES (3, 22, '2019-01-31 09:23:37');
            INSERT INTO `permission_resource`(`permission_id`, `resource_id`, `create_at`) VALUES (3, 29, '2019-01-31 09:23:37');
            INSERT INTO `permission_resource`(`permission_id`, `resource_id`, `create_at`) VALUES (3, 40, '2019-01-31 09:23:37');
            INSERT INTO `permission_resource`(`permission_id`, `resource_id`, `create_at`) VALUES (3, 41, '2019-01-31 09:23:37');
            INSERT INTO `permission_resource`(`permission_id`, `resource_id`, `create_at`) VALUES (3, 42, '2019-01-31 09:23:37');
            INSERT INTO `permission_resource`(`permission_id`, `resource_id`, `create_at`) VALUES (3, 57, '2019-01-31 09:23:37');
            INSERT INTO `permission_resource`(`permission_id`, `resource_id`, `create_at`) VALUES (4, 4, '2019-01-31 09:24:27');
            INSERT INTO `permission_resource`(`permission_id`, `resource_id`, `create_at`) VALUES (4, 15, '2019-01-31 09:24:27');
            INSERT INTO `permission_resource`(`permission_id`, `resource_id`, `create_at`) VALUES (4, 16, '2019-01-31 09:24:27');
            INSERT INTO `permission_resource`(`permission_id`, `resource_id`, `create_at`) VALUES (4, 17, '2019-01-31 09:24:27');
            INSERT INTO `permission_resource`(`permission_id`, `resource_id`, `create_at`) VALUES (4, 18, '2019-01-31 09:24:27');
            INSERT INTO `permission_resource`(`permission_id`, `resource_id`, `create_at`) VALUES (4, 32, '2019-01-31 09:24:27');
            INSERT INTO `permission_resource`(`permission_id`, `resource_id`, `create_at`) VALUES (4, 43, '2019-01-31 09:24:27');
            INSERT INTO `permission_resource`(`permission_id`, `resource_id`, `create_at`) VALUES (4, 44, '2019-01-31 09:24:27');
            INSERT INTO `permission_resource`(`permission_id`, `resource_id`, `create_at`) VALUES (4, 45, '2019-01-31 09:24:27');
            INSERT INTO `permission_resource`(`permission_id`, `resource_id`, `create_at`) VALUES (4, 46, '2019-01-31 09:24:27');
            INSERT INTO `permission_resource`(`permission_id`, `resource_id`, `create_at`) VALUES (4, 55, '2019-01-31 09:24:27');
            INSERT INTO `permission_resource`(`permission_id`, `resource_id`, `create_at`) VALUES (4, 58, '2019-01-31 09:50:17');
            INSERT INTO `permission_resource`(`permission_id`, `resource_id`, `create_at`) VALUES (4, 60, '2019-01-31 09:52:50');
            INSERT INTO `permission_resource`(`permission_id`, `resource_id`, `create_at`) VALUES (5, 3, '2019-01-31 09:25:04');
            INSERT INTO `permission_resource`(`permission_id`, `resource_id`, `create_at`) VALUES (5, 11, '2019-01-31 09:25:04');
            INSERT INTO `permission_resource`(`permission_id`, `resource_id`, `create_at`) VALUES (5, 12, '2019-01-31 09:25:04');
            INSERT INTO `permission_resource`(`permission_id`, `resource_id`, `create_at`) VALUES (5, 13, '2019-01-31 09:25:04');
            INSERT INTO `permission_resource`(`permission_id`, `resource_id`, `create_at`) VALUES (5, 14, '2019-01-31 09:25:04');
            INSERT INTO `permission_resource`(`permission_id`, `resource_id`, `create_at`) VALUES (5, 30, '2019-01-31 09:25:04');
            INSERT INTO `permission_resource`(`permission_id`, `resource_id`, `create_at`) VALUES (5, 36, '2019-01-31 09:25:04');
            INSERT INTO `permission_resource`(`permission_id`, `resource_id`, `create_at`) VALUES (5, 50, '2019-01-31 09:25:04');
            INSERT INTO `permission_resource`(`permission_id`, `resource_id`, `create_at`) VALUES (5, 51, '2019-01-31 09:25:04');
            INSERT INTO `permission_resource`(`permission_id`, `resource_id`, `create_at`) VALUES (5, 52, '2019-01-31 09:25:04');
            INSERT INTO `permission_resource`(`permission_id`, `resource_id`, `create_at`) VALUES (5, 53, '2019-01-31 09:25:04');
            INSERT INTO `permission_resource`(`permission_id`, `resource_id`, `create_at`) VALUES (5, 56, '2019-01-31 09:25:04');
            INSERT INTO `permission_resource`(`permission_id`, `resource_id`, `create_at`) VALUES (5, 59, '2019-01-31 09:50:30');
            INSERT INTO `permission_resource`(`permission_id`, `resource_id`, `create_at`) VALUES (5, 61, '2019-01-31 09:53:16');
            INSERT INTO `permission_resource`(`permission_id`, `resource_id`, `create_at`) VALUES (6, 2, '2019-01-31 09:25:35');
            INSERT INTO `permission_resource`(`permission_id`, `resource_id`, `create_at`) VALUES (6, 7, '2019-01-31 09:25:35');
            INSERT INTO `permission_resource`(`permission_id`, `resource_id`, `create_at`) VALUES (6, 8, '2019-01-31 09:25:35');
            INSERT INTO `permission_resource`(`permission_id`, `resource_id`, `create_at`) VALUES (6, 9, '2019-01-31 09:25:35');
            INSERT INTO `permission_resource`(`permission_id`, `resource_id`, `create_at`) VALUES (6, 10, '2019-01-31 09:25:35');
            INSERT INTO `permission_resource`(`permission_id`, `resource_id`, `create_at`) VALUES (6, 31, '2019-01-31 09:25:35');
            INSERT INTO `permission_resource`(`permission_id`, `resource_id`, `create_at`) VALUES (6, 47, '2019-01-31 09:25:35');
            INSERT INTO `permission_resource`(`permission_id`, `resource_id`, `create_at`) VALUES (6, 48, '2019-01-31 09:25:35');
            INSERT INTO `permission_resource`(`permission_id`, `resource_id`, `create_at`) VALUES (6, 49, '2019-01-31 09:25:35');
            INSERT INTO `permission_resource`(`permission_id`, `resource_id`, `create_at`) VALUES (6, 52, '2019-01-31 09:25:35');
            INSERT INTO `permission_resource`(`permission_id`, `resource_id`, `create_at`) VALUES (6, 54, '2019-01-31 09:25:35');
            INSERT INTO `permission_resource`(`permission_id`, `resource_id`, `create_at`) VALUES (7, 37, '2019-01-31 09:21:27');
            INSERT INTO `permission_resource`(`permission_id`, `resource_id`, `create_at`) VALUES (7, 38, '2019-01-31 09:21:27');
            INSERT INTO `permission_resource`(`permission_id`, `resource_id`, `create_at`) VALUES (8, 35, '2019-01-31 09:21:44');
            INSERT INTO `permission_resource`(`permission_id`, `resource_id`, `create_at`) VALUES (9, 25, '2019-01-31 09:21:55');
            INSERT INTO `permission_resource`(`permission_id`, `resource_id`, `create_at`) VALUES (9, 28, '2019-01-31 09:21:55');
            INSERT INTO `permission_resource`(`permission_id`, `resource_id`, `create_at`) VALUES (9, 33, '2019-01-31 09:21:55');
            EOT;

        $this->execute($sql);
    }
}
