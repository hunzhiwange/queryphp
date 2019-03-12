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
 * 配置更新.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2018.12.03
 *
 * @version 1.0
 */
class Option
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
     * @param array $input
     *
     * @return array
     */
    public function handle(array $input): array
    {
        $this->save($input);

        return [];
    }

    /**
     * 保存.
     *
     * @param array $input
     */
    protected function save(array $input): void
    {
        foreach ($input as $k => $v) {
            $this->w->replace($this->entity($k, $v));
        }

        $this->w->flush();
    }

    /**
     * 组成实体.
     *
     * @param string $name
     * @param string $value
     *
     * @return \Common\Domain\Entity\Base\Option
     */
    protected function entity(string $name, string $value): Options
    {
        return new Options(['name' => $name, 'value' => $value]);
    }
}
