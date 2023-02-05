<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Resource;

use App\Domain\Entity\User\ResourceStatusEnum;
use Leevel\Database\Proxy\Db;
use Tests\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
final class ResourcesTest extends TestCase
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
            'key' => null,
            'status' => null,
            'page' => 1,
            'size' => 10,
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

        static::assertSame(
            $data,
            $this->varJson(
                $result['page']
            )
        );

        static::assertSame([], $result['data']);
    }

    public function testWithData(): void
    {
        $this->createResource();

        $service = $this->app->container()->make(Resources::class);
        $result = $service->handle(new ResourcesParams([
            'key' => null,
            'status' => null,
            'page' => 1,
            'size' => 10,
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

        static::assertSame(
            $data,
            $this->varJson(
                $result['page']
            )
        );

        $first = $result['data'][0];

        static::assertCount(1, $result['data']);
        static::assertSame(1, $first['id']);
        static::assertSame('foo', $first['name']);
        static::assertSame('bar', $first['num']);
        static::assertSame(1, $first['status']);
    }

    protected function clear(): void
    {
        $this->truncateDatabase(['resource']);
    }

    protected function createResource(): void
    {
        static::assertSame(1, Db::table('resource')->insert([
            'name' => 'foo',
            'num' => 'bar',
            'status' => ResourceStatusEnum::ENABLE->value,
        ]));
    }
}
