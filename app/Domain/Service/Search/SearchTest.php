<?php

declare(strict_types=1);

namespace App\Domain\Service\Search;

use Tests\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
final class SearchTest extends TestCase
{
    public function testBaseUse(): void
    {
        $input = [
            'demo' => ['foo', 'bar'],
        ];

        $m = new Search();
        $result = $m->handle($input);

        $json = <<<'eot'
            {
                "demo": {
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

        static::assertSame(
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

        $m = new Search();
        $result = $m->handle($input);

        $json = <<<'eot'
            []
            eot;

        static::assertSame(
            $json,
            $this->varJson(
                $result
            )
        );
    }

    public function testSpecialKey(): void
    {
        // list 为 PHP 保留关键字，不允许作为类名字，只能是 lists
        $input = [
            'demo' => ['lists'],
        ];

        $m = new Search();
        $result = $m->handle($input);

        $json = <<<'eot'
            {
                "demo": {
                    "lists": {
                        "speciallists": {
                            "hello": "world",
                            "foo": "bar"
                        }
                    }
                }
            }
            eot;

        static::assertSame(
            $json,
            $this->varJson(
                $result
            )
        );
    }

    public function testConvert(): void
    {
        $input = [
            'demo-convert' => ['foo-Hello', 'bar_world'],
        ];

        $m = new Search();
        $result = $m->handle($input);

        $json = <<<'eot'
            {
                "demo-convert": {
                    "foo-Hello": {
                        "FooHello": {
                            "hello": "world",
                            "foo": "bar"
                        }
                    },
                    "bar_world": {
                        "FooHello": {
                            "hello": "world",
                            "foo": "bar"
                        }
                    }
                }
            }
            eot;

        static::assertSame(
            $json,
            $this->varJson(
                $result
            )
        );
    }

    public function testSearchWasNotFound(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(
            'Search condition `App\\Service\\Search\\SearchNotfound\\Notfound` was not found.'
        );

        $input = [
            'search-notfound' => ['notfound'],
        ];

        $m = new Search();
        $m->handle($input);
    }

    public function testSearchIsInvalidCallback(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(
            'Search condition `App\\Service\\Search\\Demo\\NotCallback:handle` was invalid.'
        );

        $input = [
            'demo' => ['not-callback'],
        ];

        $m = new Search();
        $m->handle($input);
    }
}
