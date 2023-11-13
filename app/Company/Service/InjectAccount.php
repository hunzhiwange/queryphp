<?php

declare(strict_types=1);

namespace App\Company\Service;

class InjectAccount
{
    /**
     * 注入账号信息.
     */
    public function handle(int $accountId, string $accountName): void
    {
        // 设置数据精度
        \App::instance('account_id', $accountId);
        \App::instance('account_name', $accountName);
    }
}
