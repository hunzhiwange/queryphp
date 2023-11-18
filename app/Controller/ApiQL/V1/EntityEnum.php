<?php

declare(strict_types=1);

namespace App\Controller\ApiQL\V1;

use App\Infra\Service\ApiQL\ApiQLEntityEnum as Service;
use App\Infra\Service\ApiQL\ApiQLEntityEnumParams;
use Leevel\Http\Request;
use Leevel\Router\Route;

/**
 * API查询语言实体枚举.
 *
 * - 示例查询语言:
 * - GET /apiQL/v1:stock:stock_log/enum/doc_type
 *
 * @codeCoverageIgnore
 */
class EntityEnum
{
    #[Route(
        path: '/apiQL/v1:{entity_class:[a-z0-9_:]+}/enum/{prop:[a-z0-9_]+}/',
        method: 'get',
    )]
    public function handle(Request $request, Service $service): array
    {
        $params = new ApiQLEntityEnumParams($request->all());

        return $service->handle($params);
    }
}
