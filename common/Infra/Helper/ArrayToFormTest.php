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

namespace Common\Infra\Helper;

use Tests\TestCase;

/**
 * @codeCoverageIgnore
 */
class ArrayToFormTest extends TestCase
{
    public function testBaseUse(): void
    {
        $data = [
            'foo' => 'bar',
        ];

        $result = explode(PHP_EOL, array_to_form($data));

        $json = <<<'eot'
            [
                "",
                "foo:bar"
            ]
            eot;

        $this->assertSame(
            $json,
            $this->varJson(
                $result
            )
        );
    }

    public function testMoreThanOne(): void
    {
        $data = [
            'company_id' => 311,
            'title'      => 'foo title',
            'content'    => 'bar content',
            'status'     => 1,
        ];

        $result = explode(PHP_EOL, array_to_form($data));

        $json = <<<'eot'
            [
                "",
                "company_id:311",
                "title:foo title",
                "content:bar content",
                "status:1"
            ]
            eot;

        $this->assertSame(
            $json,
            $this->varJson(
                $result
            )
        );
    }

    public function testArray(): void
    {
        $data = [
            'goods' => [0, 1],
        ];

        $result = explode(PHP_EOL, array_to_form($data));

        $json = <<<'eot'
            [
                "",
                "goods[0]:0",
                "goods[1]:1"
            ]
            eot;

        $this->assertSame(
            $json,
            $this->varJson(
                $result
            )
        );
    }

    public function testMap(): void
    {
        $data = [
            'goods' => ['hello' => 0, 'world' => 1],
        ];

        $result = explode(PHP_EOL, array_to_form($data));

        $json = <<<'eot'
            [
                "",
                "goods[hello]:0",
                "goods[world]:1"
            ]
            eot;

        $this->assertSame(
            $json,
            $this->varJson(
                $result
            )
        );
    }

    public function testNesting(): void
    {
        $data = [
            'goods' => ['hello' => ['foo' => 5, 'bar' => ['h', 'w']], 'world' => 1],
        ];

        $result = explode(PHP_EOL, array_to_form($data));

        $json = <<<'eot'
            [
                "",
                "goods[hello][foo]:5",
                "goods[hello][bar][0]:h",
                "goods[hello][bar][1]:w",
                "goods[world]:1"
            ]
            eot;

        $this->assertSame(
            $json,
            $this->varJson(
                $result
            )
        );
    }

    public function testWithEqual(): void
    {
        $data = [
            'goods' => ['xxx=xx', 'yy=xx'],
        ];

        $result = explode(PHP_EOL, array_to_form($data));

        $json = <<<'eot'
            [
                "",
                "goods[0]:xxx=xx",
                "goods[1]:yy=xx"
            ]
            eot;

        $this->assertSame(
            $json,
            $this->varJson(
                $result
            )
        );
    }
}

// @codeCoverageIgnoreStart
if (!function_exists('Common\\Infra\\Helper\\array_to_form')) {
    include __DIR__.'/array_to_form.php';
}
// @codeCoverageIgnoreEnd
