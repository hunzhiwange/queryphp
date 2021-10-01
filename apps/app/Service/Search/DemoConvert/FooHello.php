<?php

declare(strict_types=1);

namespace App\Service\Search\DemoConvert;

class FooHello
{
    public function handle(): array
    {
        return [
            'FooHello' => [
                'hello' => 'world',
                'foo'   => 'bar',
            ],
        ];
    }
}
