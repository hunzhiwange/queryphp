<?php

declare(strict_types=1);

namespace App\Controller\ApiQL\V1;

use App\Infra\Service\ApiQL\ApiQL as Service;
use Leevel\Http\Request;
use Leevel\Router\Route;

/**
 * API查询语言列表查询某页数据（不查询总记录）.
 *
 * - 示例查询语言:
 * - GET /apiQL/v1:user:user/list-page?column=id,name&relation[role]&page=1&size=30
 * - GET /apiQL/v1:user:user/list-page?column=id,name&relation[role]=findHot3&page=1&size=30
 * - GET /apiQL/v1:user:user/list-page?column=id,name&relation[role][setColumns]=id,create_at&page=1&size=30
 * - GET /apiQL/v1:user:user/list-page?column=id,name&relation[role][setColumns]=id,create_at&relation[role][orderBy]=create_at ASC&page=1&size=30
 *
 * @codeCoverageIgnore
 */
class IndexPage extends Index
{
    #[Route(
        path: '/apiQL/v1:{entity_class:[a-z0-9_:]+}/list-page/',
        method: 'get',
    )]
    public function handle(Request $request, Service $service): array
    {
        $request->query->set('list_page', true);

        return parent::handle($request, $service);
    }
}
