<?php

declare(strict_types=1);

/*
 * This file is part of the your app package.
 *
 * The PHP Application For Code Poem For You.
 * (c) 2018-2099 http://yourdomian.com All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Common\Domain\Service\Base;

use Common\Domain\Entity\Base\Option as Options;
use Leevel\Database\Ddd\IUnitOfWork;

/**
 * 获取配置.
 */
class GetOption
{
    private IUnitOfWork $w;

    /**
     * 构造函数.
     */
    public function __construct(IUnitOfWork $w)
    {
        $this->w = $w;
    }

    /**
     * 响应方法.
     */
    public function handle(): array
    {
        $options = $this->w
            ->repository(Options::class)
            ->findAll();
        $result = $options->toArray();

        return $result ? array_column($result, 'value', 'name') : [];
    }
}
