<?php

declare(strict_types=1);

namespace App\Controller\ApiQL\V1;

use App\Infra\Service\ApiQL\ApiQLStoreAny as Service;
use App\Infra\Service\ApiQL\ApiQLStoreAnyParams;
use Leevel\Http\Request;
use Leevel\Router\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * API查询语言保存任意格式数据.
 *
 * @codeCoverageIgnore
 */
class StoreAny
{
    #[Route(
        path: '/apiQL/v1:{entity_class:[a-z0-9_:]+}/{entity_method:[a-z0-9_:]+}/',
        method: 'post',
    )]
    public function handle(Request $request, Service $service): array|Response
    {
        $input = $request->all();
        $inputEntity = ApiQLStoreAnyParams::exceptInput($input);
        $input['entity_data'] = $inputEntity;
        $params = new ApiQLStoreAnyParams($input);

        return $service->handle($params);
    }
}
