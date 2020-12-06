<?php

declare(strict_types=1);

namespace Admin\App\Controller\Search;

use Admin\App\Controller\Support\Controller;
use Admin\App\Service\Search\Index as Service;
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
        return $this->main($request, $service);
    }

    private function input(Request $request): array
    {
        return $request->all();
    }
}
