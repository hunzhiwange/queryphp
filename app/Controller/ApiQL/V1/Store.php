<?php

declare(strict_types=1);

namespace App\Controller\ApiQL\V1;

use App\Infra\Service\ApiQL\ApiQLStore as Service;
use App\Infra\Service\ApiQL\ApiQLStoreParams;
use Leevel\Http\Request;
use Leevel\Router\Route;

/**
 * API查询语言保存数据.
 *
 * @codeCoverageIgnore
 */
class Store
{
    #[Route(
        path: '/apiQL/v1:{entity_class:[a-z0-9_:]+}/',
        method: 'post',
    )]
    public function handle(Request $request, Service $service): array
    {
        $input = $request->all();
        $inputEntity = ApiQLStoreParams::exceptInput($input);
        $input['entity_data'] = $inputEntity;
        $params = new ApiQLStoreParams($input);
        $entity = $service->handle($params);

        return $entity->id() ?: [];
    }
}
