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

namespace Common\Domain\Service\Search;

use Tests\TestCase;

/**
 * @codeCoverageIgnore
 */
class IndexTest extends TestCase
{
    public function testBaseUse(): void
    {
        $input = [
            'test' => ['foo', 'bar'],
        ];

        $m = new Index();
        $result = $m->handle($input);

        $json = <<<'eot'
{
    "test": {
        "foo": {
            "foo": {
                "hello": "world",
                "foo": "bar"
            }
        },
        "bar": {
            "foo": {
                "hello": "world",
                "foo": "bar"
            }
        }
    }
}
eot;

        $this->assertSame(
            $json,
            $this->varJson(
                $result
            )
        );
    }

    public function testItemWasNotArrayWillContinue(): void
    {
        $input = [
            'test' => 'notarray',
        ];

        $m = new Index();
        $result = $m->handle($input);

        $json = <<<'eot'
[]
eot;

        $this->assertSame(
            $json,
            $this->varJson(
                $result
            )
        );
    }

    public function testSpecialKey(): void
    {
        $input = [
            'test' => ['list'],
        ];

        $m = new Index();
        $result = $m->handle($input);

        $json = <<<'eot'
{
    "test": {
        "lists": {
            "speciallists": {
                "hello": "world",
                "foo": "bar"
            }
        }
    }
}
eot;

        $this->assertSame(
            $json,
            $this->varJson(
                $result
            )
        );
    }

    public function testConvert(): void
    {
        $input = [
            'test-convert' => ['foo-Hello', 'bar_world'],
        ];

        $m = new Index();
        $result = $m->handle($input);

        $json = <<<'eot'
{
    "testConvert": {
        "fooHello": {
            "FooHello": {
                "hello": "world",
                "foo": "bar"
            }
        },
        "barWorld": {
            "FooHello": {
                "hello": "world",
                "foo": "bar"
            }
        }
    }
}
eot;

        $this->assertSame(
            $json,
            $this->varJson(
                $result
            )
        );
    }

    public function testSearchWasNotFound(): void
    {
        $this->expectException(\Common\Infra\Exception\SearchItemNotFoundException::class);
        $this->expectExceptionMessage(
            'Service `\\Admin\\App\\Service\\Search\\SearchNotfound\\Notfound` was not found.'
        );

        $input = [
            'search-notfound' => ['notfound'],
        ];

        $m = new Index();
        $m->handle($input);
    }

    public function testSearchIsInvalidCallback(): void
    {
        $this->expectException(\Common\Infra\Exception\SearchItemNotFoundException::class);
        $this->expectExceptionMessage(
            'Service `\\Admin\\App\\Service\\Search\\Test\\NotCallback:handle` was invalid.'
        );

        $input = [
            'test' => ['not-callback'],
        ];

        $m = new Index();
        $m->handle($input);
    }
}
