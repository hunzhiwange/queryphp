<?php

declare(strict_types=1);

namespace Admin\Service\Search\TestConvert;

class FooHello
{
    public function handle(array $input): array
    {
        return [
            'FooHello' => [
                'hello' => 'world',
                'foo'   => 'bar',
            ],
        ];
    }
}
