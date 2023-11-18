<?php

declare(strict_types=1);

namespace App\Project\Controller\ApiQL\V1\ProjectTag;

use App\Controller\Support\Controller;
use App\Project\Service\ProjectTag\ProjectTags as Service;
use App\Project\Service\ProjectTag\ProjectTagsParams;
use Leevel\Http\Request;

/**
 * 项目标签列表.
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
        $params = new ProjectTagsParams($input);

        return $service->handle($params);
    }
}
