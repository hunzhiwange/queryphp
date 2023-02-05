<?php

declare(strict_types=1);

namespace App\Service\Search\Demo;

class Foo
{
    public function handle(): array
    {
        return [
            'foo' => [
                'hello' => 'world',
                'foo' => 'bar',
            ],
        ];
    }
}
