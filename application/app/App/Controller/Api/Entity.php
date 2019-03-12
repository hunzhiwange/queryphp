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

namespace App\App\Controller\Api;

use Common\Domain\Entity\Demo\Test;
use Leevel\Database\Ddd\UnitOfWork;
use Leevel\Database\Facade\Db;

/**
 * 实体使用.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2018.11.08
 *
 * @version 1.0
 */
class Entity
{
    /**
     * 默认方法.
     *
     * @param \Leevel\Database\Ddd\UnitOfWork $w
     *
     * @return array
     */
    public function handle(/*UnitOfWork $w*/): array
    {
        $x = new Test(['name' => 'hello world']);

        // $w->persist(new Test(['name' => 'hello world']));
        // $w->persist(new Test(['name' => 'foo bar']));

        // $w->flush();

        //Db::table('test')->insert(['name' => '小马哥']);

        print_r(get_included_files());

        return ['count' => Test::findCount()];
    }
}
