<?php

declare(strict_types=1);

namespace App\Controller\ApiQL\V1;

use App\Infra\Service\ApiQL\ApiQLEntityStruct as Service;
use App\Infra\Service\ApiQL\ApiQLEntityStructParams;
use Leevel\Http\Request;
use Leevel\Router\Route;

/**
 * API查询语言实体结构.
 *
 * - 示例查询语言:
 * - GET /apiQL/v1:stock:stock_log/struct
 *
 * @codeCoverageIgnore
 */
class EntityStruct
{
    #[Route(
        path: '/apiQL/v1:{entity_class:[a-z0-9_:]+}/struct/',
        method: 'get',
    )]
    public function handle(Request $request, Service $service): array
    {
        $params = new ApiQLEntityStructParams($request->all());

        return $service->handle($params);
    }
}
