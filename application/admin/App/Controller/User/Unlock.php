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

namespace Admin\App\Controller\User;

use Admin\App\Controller\Support\Controller;
use Admin\App\Service\User\Unlock as Service;
use Leevel\Auth\Proxy\Auth;
use Leevel\Http\IRequest;

/**
 * 解锁.
 *
 * @codeCoverageIgnore
 */
class Unlock
{
    use Controller;

    private array $allowedInput = [
        'password',
    ];

    public function handle(IRequest $request, Service $service): array
    {
        return $this->main($request, $service);
    }

    private function extendInput(IRequest $request): array
    {
        return [
            'id'    => $this->id(),
            'token' => $this->token(),
        ];
    }

    /**
     * 获取 Token.
     */
    private function token(): string
    {
        return Auth::getTokenName();
    }

    /**
     * 获取用户 ID.
     */
    private function id(): int
    {
        return (int) Auth::getLogin()['id'];
    }
}
