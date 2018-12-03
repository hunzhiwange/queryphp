<?php

declare(strict_types=1);

/*
 * This file is part of the forcodepoem package.
 *
 * The PHP Application Created By Code Poem. <Query Yet Simple>
 * (c) 2018-2099 http://forcodepoem.com All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Admin\App\Service\Base;

use Common\Domain\Entity\Option as Options;
use Leevel\Database\Ddd\IUnitOfWork;

/**
 * 获取配置.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2018.12.03
 *
 * @version 1.0
 */
class GetOption
{
    /**
     * 事务工作单元.
     *
     * @var \Leevel\Database\Ddd\IUnitOfWork
     */
    protected $w;

    /**
     * 构造函数.
     *
     * @param \Leevel\Database\Ddd\IUnitOfWork $w
     */
    public function __construct(IUnitOfWork $w)
    {
        $this->w = $w;
    }

    /**
     * 响应方法.
     *
     * @return array
     */
    public function handle(): array
    {
        $options = $this->w->repository(Options::class)->findAll();

        $result = $options->toArray();

        return $result ? array_column($result, 'value', 'name') : [];
    }
}
