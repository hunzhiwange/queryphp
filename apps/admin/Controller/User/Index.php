<?php

declare(strict_types=1);

namespace Admin\Controller\User;

use Admin\Controller\Support\Controller;
use App\Domain\Service\User\User\Users as Service;
use App\Domain\Service\User\User\UsersParams;
use Leevel\Http\Request;

/**
 * 用户列表.
 *
 * @codeCoverageIgnore
 */
class Index
{
    use Controller;

    private array $allowedInput = [
        'key',
        'status',
        'page',
        'size',
        'column',
        'order_by',
    ];

    public function handle(Request $request, Service $service): array
    {
        $input = $this->input($request);
        $params = new UsersParams($input);

        return $service->handle($params);
    }
}
