<?php

declare(strict_types=1);

namespace App\Controller\ApiQL\V1;

use App\Infra\Service\ApiQL\ApiQLBatch as Service;
use App\Infra\Service\ApiQL\ApiQLBatchParams;
use Leevel\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * API批量查询语言.
 *
 * - 示例查询:
 * - GET http://127.0.0.1:9529/apiQL/v1:batch?apis[]=user&apis[]=role&params[0][page]=1&params[0][size]=30&params[1][page]=1&params[1][size]=30
 *
 * @codeCoverageIgnore
 */
class Batch
{
    public function index(Request $request, Service $service): Response
    {
        $params = new ApiQLBatchParams($request->all());

        return $service->handle($params, $request);
    }
}
