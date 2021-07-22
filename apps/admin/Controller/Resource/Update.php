<?php

declare(strict_types=1);

namespace Admin\Controller\Resource;

use Admin\Controller\Support\Controller;
use App\Domain\Service\User\Resource\Update as Service;
use App\Domain\Service\User\Resource\UpdateParams;
use Leevel\Http\Request;

/**
 * 资源更新.
 *
 * @codeCoverageIgnore
 */
class Update
{
    use Controller;

    private array $allowedInput = [
        'id',
        'name',
        'num',
        'status',
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
