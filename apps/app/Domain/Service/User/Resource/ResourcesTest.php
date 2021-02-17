<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Resource;

use App\Domain\Entity\User\Resource;
use Leevel\Database\Proxy\Db;
use Tests\TestCase;

class ResourcesTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->clear();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->clear();
    }

    public function testBaseUse(): void
    {
        $service = $this->app->container()->make(Resources::class);
        $result = $service->handle(new ResourcesParams([
            'key'    => null,
            'status' => null,
            'page'   => 1,
            'size'   => 10,
        ]));

        $data = <<<'eot'
            {
                "per_page": 10,
                "current_page": 1,
                "total_page": 0,
                "total_record": 0,
                "total_macro": false,
                "from": 0,
                "to": 0
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

    public function testWithData(): void
    {
        $this->createResource();

        $service = $this->app->container()->make(Resources::class);
        $result = $service->handle(new ResourcesParams([
            'key'    => null,
            'status' => null,
            'page'   => 1,
            'size'   => 10,
        ]));

        $data = <<<'eot'
            {
                "per_page": 10,
                "current_page": 1,
                "total_page": 1,
                "total_record": 1,
                "total_macro": false,
                "from": 0,
                "to": 1
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
        $this->assertSame(1, $first['id']);
        $this->assertSame('foo', $first['name']);
        $this->assertSame('bar', $first['num']);
        $this->assertSame(1, $first['status']);
    }

    protected function clear()
    {
        $this->truncateDatabase(['resource']);
    }

    protected function createResource()
    {
        $this->assertSame(1, Db::table('resource')->insert([
            'name'     => 'foo',
            'num'      => 'bar',
            'status'   => Resource::STATUS_ENABLE,
        ]));
    }
}
