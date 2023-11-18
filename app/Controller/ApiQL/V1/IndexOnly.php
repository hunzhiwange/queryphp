<?php

declare(strict_types=1);

namespace App\Controller\ApiQL\V1;

use App\Infra\Service\ApiQL\ApiQL as Service;
use Leevel\Http\Request;
use Leevel\Router\Route;

/**
 * API查询语言列表（只查询列表）.
 *
 * - 最大只能查询 2000 条数据.
 * - 示例查询语言:
 * - GET /apiQL/v1:user:user/list-only/?column=id,name&relation[role]&page=1&size=30
 * - GET /apiQL/v1:user:user/list-only?column=id,name&relation[role]=findHot3&page=1&size=30
 * - GET /apiQL/v1:user:user/list-only?column=id,name&relation[role][setColumns]=id,create_at&page=1&size=30
 * - GET /apiQL/v1:user:user/list-only?column=id,name&relation[role][setColumns]=id,create_at&relation[role][orderBy]=create_at ASC&page=1&size=30
 *
 * @codeCoverageIgnore
 */
class IndexOnly extends Index
{
    #[Route(
        path: '/apiQL/v1:{entity_class:[a-z0-9_:]+}/list-only/',
        method: 'get',
    )]
    public function handle(Request $request, Service $service): array
    {
        $request->query->set('list_only', true);

        return parent::handle($request, $service);
    }
}
