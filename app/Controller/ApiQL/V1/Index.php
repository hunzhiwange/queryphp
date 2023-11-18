<?php

declare(strict_types=1);

namespace App\Controller\ApiQL\V1;

use App\Infra\Service\ApiQL\ApiQL as Service;
use App\Infra\Service\ApiQL\ApiQLParams;
use App\Infra\Service\Support\ReadParams;
use Leevel\Http\Request;
use Leevel\Router\Route;

/**
 * API查询语言列表.
 *
 * - 示例查询语言:
 * - GET /apiQL/v1:user:user?column=id,name&relation[role]&page=1&size=30
 * - GET /apiQL/v1:user:user?column=id,name&relation[role]=findHot3&page=1&size=30
 * - GET /apiQL/v1:user:user?column=id,name&relation[role][setColumns]=id,create_at&page=1&size=30
 * - GET /apiQL/v1:user:user?column=id,name&relation[role][setColumns]=id,create_at&relation[role][orderBy]=create_at ASC&page=1&size=30
 *
 * @codeCoverageIgnore
 */
class Index
{
    #[Route(
        path: '/apiQL/v1:{entity_class:[a-z0-9_:]+}/',
        method: 'get',
    )]
    public function handle(Request $request, Service $service): array
    {
        $input = $request->all();
        $inputWhere = ReadParams::exceptInput($input);
        if (isset($input['where'])) {
            $inputWhere = array_merge($inputWhere, $input['where']);
        }
        $input['where'] = $inputWhere;
        $params = new ApiQLParams($input);

        return $service->handle($params);
    }
}
