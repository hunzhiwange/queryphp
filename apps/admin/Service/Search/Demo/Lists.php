<?php

declare(strict_types=1);

namespace Admin\Service\Search\Demo;

class Lists
{
    public function handle(array $input): array
    {
        return [
            'speciallists' => [
                'hello' => 'world',
                'foo'   => 'bar',
            ],
        ];
    }
}
