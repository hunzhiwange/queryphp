<?php

declare(strict_types=1);

namespace App\Controller\ApiQL\V1;

use App\Infra\Service\ApiQL\ApiQLDestroy as Service;
use App\Infra\Service\ApiQL\ApiQLDestroyParams;
use Leevel\Http\Request;
use Leevel\Router\Route;

/**
 * API查询语言删除数据.
 *
 * @codeCoverageIgnore
 */
class Destroy
{
    #[Route(
        path: '/apiQL/v1:{entity_class:[a-z0-9_:]+}/{id:[0-9]+}/',
        method: 'delete',
    )]
    public function handle(Request $request, Service $service): array
    {
        $params = new ApiQLDestroyParams($request->all());

        return $service->handle($params);
    }
}
