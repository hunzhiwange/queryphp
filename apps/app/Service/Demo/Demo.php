<?php

declare(strict_types=1);

namespace App\Service\Demo;

class Demo
{
    public function handle(): array
    {
        // 假装很复杂的计算
        return ['hello' => 'world'];
    }
}
