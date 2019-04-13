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

namespace Tests\Admin\Service\Resource;

use Admin\App\Service\Resource\Index;
use Admin\App\Service\Resource\Store;
use Tests\TestCase;

/**
 * IndexTest.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2018.11.20
 *
 * @version 1.0
 */
class IndexTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();

        $this->clear();
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->clear();
    }

    public function testBaseUse()
    {
        $service = $this->app->make(Index::class);

        $result = $service->handle([
            'key'    => '',
            'status' => '',
            'page'   => 1,
            'size'   => 10,
        ]);

        $data = <<<'eot'
            {
                "per_page": 10,
                "current_page": 1,
                "total_record": 0,
                "from": 0
            }
            eot;

        $this->assertSame(
            $data,
            $this->varJson(
                $result['page']
            )
        );

        $this->assertSame([], $result['data']);
    }

    public function testWithData()
    {
        $this->createResource();

        $service = $this->app->make(Index::class);

        $result = $service->handle([
            'key'    => '',
            'status' => '',
            'page'   => 1,
            'size'   => 10,
        ]);

        $data = <<<'eot'
            {
                "per_page": 10,
                "current_page": 1,
                "total_record": 1,
                "from": 0
            }
            eot;

        $this->assertSame(
            $data,
            $this->varJson(
                $result['page']
            )
        );

        $first = $result['data'][0];

        $this->assertCount(1, $result['data']);
        $this->assertSame('1', $first['id']);
        $this->assertSame('foo', $first['name']);
        $this->assertSame('bar', $first['identity']);
        $this->assertSame('1', $first['status']);
    }

    protected function clear()
    {
        $this->truncateDatabase(['resource']);
    }

    protected function createResource()
    {
        $service = $this->app->make(Store::class);

        $service->handle([
            'name'     => 'foo',
            'identity' => 'bar',
            'status'   => '1',
        ]);
    }
}
