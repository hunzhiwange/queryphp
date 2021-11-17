<?php

declare(strict_types=1);

namespace App\Controller\Api\V1\ProjectType;

use App\Controller\Support\Controller;
use App\Domain\Service\Project\ProjectType\ProjectTypes as Service;
use App\Domain\Service\Project\ProjectType\ProjectTypesParams;
use Leevel\Http\Request;

/**
 * 项目类型列表.
 *
 * @codeCoverageIgnore
 */
class Index
{
    use Controller;

    private array $allowedInput = [
        'key',
        'status',
        'page',
        'size',
    ];

    public function handle(Request $request, Service $service): array
    {
        $input = $this->input($request);
        $params = new ProjectTypesParams($input);

        return $service->handle($params);
    }
}
