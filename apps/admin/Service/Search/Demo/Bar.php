<?php

declare(strict_types=1);

namespace Admin\Service\Search\Demo;

class Bar
{
    public function handle(array $input): array
    {
        return [
            'foo' => [
                'hello' => 'world',
                'foo'   => 'bar',
            ],
        ];
    }
}
