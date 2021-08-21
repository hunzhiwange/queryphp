<?php

declare(strict_types=1);

namespace App\Controller\Api\V1\User;

use App\Controller\Support\Controller;
use App\Domain\Service\User\User\Update as Service;
use App\Domain\Service\User\User\UpdateParams;
use Leevel\Auth\Proxy\Auth;
use Leevel\Http\Request;

/**
 * 用户修改资料.
 *
 * @codeCoverageIgnore
 */
class UpdateInfo
{
    use Controller;

    private array $allowedInput = [
        'email',
        'mobile',
    ];

    public function handle(Request $request, Service $service): array
    {
        $params = new UpdateParams($this->input($request));

        return $service->handle($params);
    }

    private function extendInput(): array
    {
        return ['id' => $this->userId()];
    }
}
