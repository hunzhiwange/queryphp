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

namespace Common\Infra\Repository\User\User;

use Admin\Infra\Lock as CacheLock;
use Leevel\Validate\Proxy\Validate as Validates;

/**
 * 锁定管理面板
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.11.21
 *
 * @version 1.0
 */
class Lock
{
    /**
     * 锁定缓存.
     *
     * @var \Admin\Infra\Lock
     */
    protected $lock;

    /**
     * 输入数据.
     *
     * @var array
     */
    protected $input;

    /**
     * 构造函数.
     *
     * @param \Admin\Infra\Lock $lock
     */
    public function __construct(CacheLock $lock)
    {
        $this->lock = $lock;
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
        $this->input = $input;

        $this->validateArgs();

        $this->lock();

        return [];
    }

    /**
     * 锁定.
     */
    protected function lock()
    {
        $this->lock->set($this->input['token']);
    }

    /**
     * 校验基本参数.
     */
    protected function validateArgs()
    {
        $validator = Validates::make(
            $this->input,
            [
                'token'       => 'required',
            ],
            [
                'token'      => 'Token',
            ]
        );

        if ($validator->fail()) {
            throw new HandleException(json_encode($validator->error()));
        }
    }
}
