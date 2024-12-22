<?php

declare(strict_types=1);

namespace App\Infra\Service;

class Demo
{
    public function handle(DemoParams $params): array
    {
        $params->validate();

        return [
            'hello' => 'world',
        ];
    }
}
