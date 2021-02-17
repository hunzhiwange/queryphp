<?php

declare(strict_types=1);

namespace Admin\Controller\Resource;

use Admin\Controller\Support\Controller;
use App\Domain\Service\User\Resource\Resources as Service;
use App\Domain\Service\User\Resource\ResourcesParams;
use Leevel\Http\Request;

/**
 * 资源列表.
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
    ];

    public function handle(Request $request, Service $service): array
    {
        $input = $this->input($request);
        $params = new ResourcesParams($input);

        return $service->handle($params);;
    }
}
