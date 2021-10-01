<?php

declare(strict_types=1);

namespace App\Service\Search\Demo;

class Lists
{
    public function handle(): array
    {
        return [
            'speciallists' => [
                'hello' => 'world',
                'foo'   => 'bar',
            ],
        ];
    }
}
