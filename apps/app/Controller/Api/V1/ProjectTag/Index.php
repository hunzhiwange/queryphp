<?php

declare(strict_types=1);

namespace App\Controller\Api\V1\ProjectTag;

use App\Controller\Support\Controller;
use App\Domain\Service\Project\ProjectTag\ProjectTags as Service;
use App\Domain\Service\Project\ProjectTag\ProjectTagsParams;
use Leevel\Http\Request;

/**
 * 项目标签列表.
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
        $params = new ProjectTagsParams($input);

        return $service->handle($params);;
    }
}
