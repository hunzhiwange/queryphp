<?php

declare(strict_types=1);

namespace App\Controller\ApiQL\V1;

use App\Infra\Service\ApiQL\ApiQLUpdate as Service;
use App\Infra\Service\ApiQL\ApiQLUpdateParams;
use Leevel\Http\Request;
use Leevel\Router\Route;

/**
 * API查询语言更新数据.
 *
 * @codeCoverageIgnore
 */
class Update
{
    #[Route(
        path: '/apiQL/v1:{entity_class:[a-z0-9_:]+}/{id:[0-9]+}/',
        method: 'put',
    )]
    public function handle(Request $request, Service $service): array
    {
        $input = $request->all();
        $inputEntity = ApiQLUpdateParams::exceptInput($input);
        $input['entity_data'] = $inputEntity;
        $params = new ApiQLUpdateParams($input);
        $entity = $service->handle($params);

        return $entity->id() ?: [];
    }
}
