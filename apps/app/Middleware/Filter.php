<?php

declare(strict_types=1);

namespace App\Middleware;

use Closure;
use Leevel\Http\Request;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Response;

/**
 * 过滤输入中间件.
 */
class Filter
{
    public function handle(Closure $next, Request $request): Response
    {
        $this->filterRequest($request);
        
        return $next($request);
    }

    protected function filterRequest(Request $request): void
    {
        if (Request::METHOD_GET === $request->getMethod()) {
            $this->filterParameterBag($request->query);
        } else {
            $this->filterParameterBag($request->query);
            $this->filterParameterBag($request->request);
        }
    }

    protected function filterParameterBag(ParameterBag $bag): void
    {
        $bag->replace($this->filterArray($bag->all()));
    }

    protected function filterArray(array $data): array
    { 
        array_walk(
            $data,
            fn (mixed &$value, string $key) => $value = $this->transformValue($value, $key),
        );

        return $data;
    }

    protected function transformValue(mixed $value, string $key): mixed
    {
        if (!is_string($value)) {
            return $value;
        }

        $value = trim($value);
        if ('' === $value) {
            return null;
        }

        return $value;
    }
}
