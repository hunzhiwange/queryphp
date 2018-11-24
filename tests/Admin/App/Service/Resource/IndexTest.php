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
        $service = $this->project->make(Index::class);

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

        $service = $this->project->make(Index::class);

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

        $this->assertSame(1, count($result['data']));
        $this->assertSame('1', $first['id']);
        $this->assertSame('foo', $first['name']);
        $this->assertSame('bar', $first['identity']);
        $this->assertSame('1', $first['status']);
        $this->assertContains(date('Y-m-d'), $first['create_at']);
    }

    protected function clear()
    {
        $this->truncateDatabase(['resource']);
    }

    protected function createResource()
    {
        $service = $this->project->make(Store::class);

        $service->handle([
            'name'     => 'foo',
            'identity' => 'bar',
            'status'   => '1',
        ]);
    }
}
