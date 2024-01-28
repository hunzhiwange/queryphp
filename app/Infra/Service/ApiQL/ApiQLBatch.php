<?php

declare(strict_types=1);

namespace App\Infra\Service\ApiQL;

use Leevel\Http\Request;
use Leevel\Kernel\IKernel;
use Symfony\Component\HttpFoundation\Response;
use Swoole\Coroutine\WaitGroup;
use Swoole\Coroutine;

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

        // 非协程模式
        $call = function(string $key, string $api) use(
            $baseRequest,
            $params,
            $kernel,
            &$firstResponse,
            &$errorResponse,
            &$responseAll,
        )  {
            $request = clone $baseRequest;
            $request->query->add($params->params[$key]);
            $request->setPathInfo('/apiQL/v1:'.$api);
            $response = $kernel->handle($request);
            $responseAll[$key] = $response;
            if (!$response->isOk()) {
                $errorResponse = $response;
            }

            if (!$firstResponse) {
                $firstResponse = $response;
            }

            $kernel->terminate($request, $response);
        };

        // 协程模式
        $enabledCoroutine = \enabledCoroutine();
        if ($enabledCoroutine) {
            $wg = new WaitGroup();
            $call = function(string $key, string $api) use($call, $wg) :void {
                // 启动一个协程
                $wg->add();
                Coroutine::create(function() use($key, $api, $call, $wg):void {
                    $call($key, $api);
                    // 标记协程完成
                    $wg->done();
                });
            };
        }

        foreach ($params->apis as $key => $api) {
            $call($key, $api);
        }

        if ($enabledCoroutine) {
            // 挂起当前协程，等待所有任务完成后恢复
            $wg->wait();
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
