<?php

declare(strict_types=1);

namespace App\Infra\Helper;

use Tests\TestCase;

final class Array2FormTest extends TestCase
{
    public function testBaseUse(): void
    {
        $data = [
            'foo' => 'bar',
        ];

        $result = explode(PHP_EOL, Array2Form::handle($data));

        $json = <<<'eot'
            [
                "",
                "foo:bar"
            ]
            eot;

        static::assertSame(
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
            'title' => 'foo title',
            'content' => 'bar content',
            'status' => 1,
        ];

        $result = explode(PHP_EOL, Array2Form::handle($data));

        $json = <<<'eot'
            [
                "",
                "company_id:311",
                "title:foo title",
                "content:bar content",
                "status:1"
            ]
            eot;

        static::assertSame(
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

        $result = explode(PHP_EOL, Array2Form::handle($data));

        $json = <<<'eot'
            [
                "",
                "goods[0]:0",
                "goods[1]:1"
            ]
            eot;

        static::assertSame(
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

        $result = explode(PHP_EOL, Array2Form::handle($data));

        $json = <<<'eot'
            [
                "",
                "goods[hello]:0",
                "goods[world]:1"
            ]
            eot;

        static::assertSame(
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

        $result = explode(PHP_EOL, Array2Form::handle($data));

        $json = <<<'eot'
            [
                "",
                "goods[hello][foo]:5",
                "goods[hello][bar][0]:h",
                "goods[hello][bar][1]:w",
                "goods[world]:1"
            ]
            eot;

        static::assertSame(
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

        $result = explode(PHP_EOL, Array2Form::handle($data));

        $json = <<<'eot'
            [
                "",
                "goods[0]:xxx=xx",
                "goods[1]:yy=xx"
            ]
            eot;

        static::assertSame(
            $json,
            $this->varJson(
                $result
            )
        );
    }
}
