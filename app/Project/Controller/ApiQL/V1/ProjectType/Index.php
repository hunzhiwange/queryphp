<?php

declare(strict_types=1);

namespace App\Project\Controller\ApiQL\V1\ProjectType;

use App\Controller\Support\Controller;
use App\Project\Service\ProjectType\ProjectTypes as Service;
use Leevel\Http\Request;

/**
 * 项目类型列表.
 *
 * @codeCoverageIgnore
 */
class Index
{
    use Controller;

    private array $allowedInput = [];

    public function handle(Request $request, Service $service): array
    {
        $input = $this->input($request);
        $params = new \App\Project\Service\ProjectType\ProjectTypesParams($input);

        return $service->handle($params);
    }
}
