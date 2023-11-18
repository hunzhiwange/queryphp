<?php

declare(strict_types=1);

namespace App\Infra\Middleware;

use Leevel\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

/**
 * 过滤输入中间件.
 */
class Filter
{
    public function handle(\Closure $next, Request $request): Response
    {
        $this->filterRequest($request);
        $response = $next($request);

        if (\in_array($request->getMethod(), [
            Request::METHOD_PATCH,
            Request::METHOD_POST,
            Request::METHOD_PUT,
            Request::METHOD_DELETE,
        ], true)
            && $response instanceof JsonResponse
            && \is_array($data = $this->jsonStringToArray($response->getContent()))
            && !isset($data['success'])
            && !isset($data['error'])) {
            $response->setData(success_message($data));
        }

        return $response;
    }

    /**
     * JSON 字符串转为数组.
     */
    protected function jsonStringToArray(false|string $value): mixed
    {
        if (!\is_string($value)) {
            return false;
        }

        try {
            return json_decode($value, true, 512, JSON_THROW_ON_ERROR);
        } catch (Throwable) {
            return false;
        }
    }

    protected function filterRequest(Request $request): void
    {
        if (Request::METHOD_GET === $request->getMethod()) {
            $this->filterParameterBag($request->query);
        } else {
            $this->filterParameterBag($request->query);
            $this->filterParameterBag($request->request, true);
        }
    }

    protected function filterParameterBag(ParameterBag $bag, bool $keepEmptyString = false): void
    {
        $bag->replace($this->filterArray($bag->all(), $keepEmptyString));
    }

    protected function filterArray(array $data, bool $keepEmptyString): array
    {
        array_walk(
            $data,
            fn (mixed & $value, string $key) => $value = $this->transformValue($value, $key, $keepEmptyString),
        );

        return $data;
    }

    protected function transformValue(mixed $value, string $key, bool $keepEmptyString): mixed
    {
        if (!\is_string($value)) {
            return $value;
        }

        $value = trim($value);

        if (!$keepEmptyString && '' === $value) {
            return null;
        }

        return $value;
    }
}
