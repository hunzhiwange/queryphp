<?php

declare(strict_types=1);

namespace App\Service\Search\DemoConvert;

class BarWorld
{
    public function handle(): array
    {
        return [
            'FooHello' => [
                'hello' => 'world',
                'foo' => 'bar',
            ],
        ];
    }
}
