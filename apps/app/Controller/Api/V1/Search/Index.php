<?php

declare(strict_types=1);

namespace App\Controller\Api\V1\Search;

use App\Controller\Support\Controller;
use App\Service\Search\Search as Service;
use Leevel\Http\Request;

/**
 * 公共搜索列表.
 *
 * @codeCoverageIgnore
 */
class Index
{
    use Controller;

    public function handle(Request $request, Service $service): array
    {
        return $service->handle($this->input($request));
    }

    private function input(Request $request): array
    {
        return $request->all();
    }
}
