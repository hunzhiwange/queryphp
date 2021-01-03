<?php

declare(strict_types=1);

namespace App\Domain\Service\User\User;

use Admin\Infra\Lock as CacheLock;
use App\Exceptions\BusinessException;
use Leevel\Validate\Proxy\Validate as Validates;

/**
 * 锁定管理面板
 */
class Lock
{
    private array $input;

    public function __construct(private CacheLock $lock)
    {
    }

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
    private function lock(): void
    {
        $this->lock->set($this->input['token']);
    }

    /**
     * 校验基本参数.
     *
     * @throws \App\Exceptions\BusinessException
     */
    private function validateArgs(): void
    {
        $validator = Validates::make(
            $this->input,
            [
                'token'  => 'required',
            ],
            [
                'token' => 'Token',
            ]
        );

        if ($validator->fail()) {
            $e = json_encode($validator->error(), JSON_UNESCAPED_UNICODE);

            throw new BusinessException($e);
        }
    }
}
