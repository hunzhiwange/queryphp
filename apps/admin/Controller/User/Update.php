<?php

declare(strict_types=1);

namespace Admin\Controller\User;

use Admin\Controller\Support\Controller;
use App\Domain\Service\User\User\Update as Service;
use App\Domain\Service\User\User\UpdateParams;
use Leevel\Http\Request;

/**
 * 用户更新.
 *
 * @codeCoverageIgnore
 */
class Update
{
    use Controller;

    private array $allowedInput = [
        'id',
        'num',
        'status',
        'userRole',
        'password',
    ];

    public function handle(Request $request, Service $service): array
    {
        $params = new UpdateParams($this->input($request));

        return $service->handle($params);
    }

    private function extendInput(Request $request): array
    {
        return $this->restfulInput($request);
    }
}
