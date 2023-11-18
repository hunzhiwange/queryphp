<?php

declare(strict_types=1);

namespace App\Controller\ApiQL\V1;

use App\Infra\Service\ApiQL\ApiQLUpdateAny as Service;
use App\Infra\Service\ApiQL\ApiQLUpdateAnyParams;
use Leevel\Http\Request;
use Leevel\Router\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * API查询语言更新任意格式数据.
 *
 * @codeCoverageIgnore
 */
class UpdateAny
{
    #[Route(
        path: '/apiQL/v1:{entity_class:[a-z0-9_:]+}/{id:[0-9]+}/{entity_method:[a-z0-9_:]+}/',
        method: 'put',
    )]
    public function handle(Request $request, Service $service): array|Response
    {
        $input = $request->all();
        $inputEntity = ApiQLUpdateAnyParams::exceptInput($input);
        $input['entity_data'] = $inputEntity;
        $params = new ApiQLUpdateAnyParams($input);

        return $service->handle($params);
    }
}
