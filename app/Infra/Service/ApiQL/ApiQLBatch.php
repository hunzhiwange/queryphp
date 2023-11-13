<?php

declare(strict_types=1);

namespace App\Infra\Service\ApiQL;

use Leevel\Http\Request;
use Leevel\Kernel\IKernel;
use Symfony\Component\HttpFoundation\Response;

/**
 * API批量查询语言.
 */
class ApiQLBatch
{
    public function handle(ApiQLBatchParams $params, Request $baseRequest): Response
    {
        $params->validate();

        /** @var \Leevel\Kernel\IKernel $kernel */
        $kernel = container()->make(IKernel::class);
        $baseRequest->query->remove('apis');
        $baseRequest->query->remove('params');

        container()->instance('ignore_validate_signature', true);

        $responseAll = [];
        $errorResponse = null;
        $firstResponse = null;
        foreach ($params->apis as $key => $api) {
            $request = clone $baseRequest;
            $request->query->add($params->params[$key]);
            $request->setPathInfo('/apiQL/v1:'.$api);
            $response = $kernel->handle($request);
            $responseAll[$key] = $response;
            if (!$response->isOk()) {
                $errorResponse = $response;

                break;
            }
            if (!$firstResponse) {
                $firstResponse = $response;
            }

            $kernel->terminate($request, $response);
        }

        if ($errorResponse) {
            return $errorResponse;
        }
        if (!$firstResponse) {
            throw new \RuntimeException('Response is empty.');
        }

        $responseContent = [];

        /** @var Response $v */
        foreach ($responseAll as $k => $v) {
            $responseContent[] = '"'.$k.'":'.$v->getContent();
        }
        // 拼接成 JSON 格式
        $content = '{'.implode(',', $responseContent).'}';
        $firstResponse->setContent($content);

        return $firstResponse;
    }
}
