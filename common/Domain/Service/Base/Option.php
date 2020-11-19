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
use Leevel\Database\Ddd\UnitOfWork;

/**
 * 配置更新.
 */
class Option
{
    public function __construct(private UnitOfWork $w)
    {
    }

    public function handle(array $input): array
    {
        $this->save($input);

        return [];
    }

    /**
     * 保存.
     */
    private function save(array $input): void
    {
        foreach ($input as $k => $v) {
            $this->w->update($this->entity($k, $v));
        }

        $this->w->flush();
    }

    /**
     * 组成实体.
     */
    private function entity(string $name, string $value): Options
    {
        $option = Options::select()
            ->where(['name' => $name])
            ->setColumns('id,name')
            ->findOne();

        $option->value = $value;

        return $option;
    }
}
