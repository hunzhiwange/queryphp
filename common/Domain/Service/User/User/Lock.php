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

namespace Common\Domain\Service\User\User;

use Admin\Infra\Lock as CacheLock;
use Leevel\Validate\Proxy\Validate as Validates;

/**
 * 锁定管理面板
 */
class Lock
{
    /**
     * 锁定缓存.
     *
     * @var \Admin\Infra\Lock
     */
    private $lock;

    private array $input;

    /**
     * 构造函数.
     */
    public function __construct(CacheLock $lock)
    {
        $this->lock = $lock;
    }

    /**
     * 响应方法.
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
    private function lock()
    {
        $this->lock->set($this->input['token']);
    }

    /**
     * 校验基本参数.
     *
     * @throws \Common\Infra\Exception\BusinessException
     */
    private function validateArgs()
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
            throw new BusinessException(json_encode($validator->error()));
        }
    }
}
