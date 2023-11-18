<?php

declare(strict_types=1);

namespace App\Controller\ApiQL\V1;

use App\Infra\Service\ApiQL\ApiQLPatch as Service;
use App\Infra\Service\ApiQL\ApiQLPatchParams;
use Leevel\Http\Request;
use Leevel\Router\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * API查询语言局部更新数据.
 *
 * @codeCoverageIgnore
 */
class Patch
{
    #[Route(
        path: '/apiQL/v1:{entity_class:[a-z0-9_:]+}/{id:[0-9]+}/{entity_method:[a-z0-9_:]+}/',
        method: 'patch',
    )]
    public function handle(Request $request, Service $service): array|Response
    {
        $input = $request->all();
        $inputEntity = ApiQLPatchParams::exceptInput($input);
        $input['entity_data'] = $inputEntity;
        $params = new ApiQLPatchParams($input);

        return $service->handle($params);
    }
}
