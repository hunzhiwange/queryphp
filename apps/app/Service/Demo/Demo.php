<?php

declare(strict_types=1);

namespace App\Service\Demo;

/**
 * 应用服务层.
 *
 * - 控制器应该足够精简，如果控制器存在一些逻辑处理可以移动到应用服务层
 * - 如果控制器本身太过于简单，那么此时是不需要应用服务层的
 */
class Demo
{
    public function handle(): array
    {
        // 假装很复杂的计算
        return ['hello' => 'world'];
    }
}
