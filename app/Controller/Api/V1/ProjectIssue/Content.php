<?php

declare(strict_types=1);

namespace App\Controller\Api\V1\ProjectIssue;

use App\Controller\Support\Controller;
use App\Domain\Service\Project\ProjectIssue\Update as Service;
use App\Domain\Service\Project\ProjectIssue\UpdateParams;
use Leevel\Http\Request;

/**
 * 项目问题内容更新.
 *
 * @codeCoverageIgnore
 */
class Content
{
    use Controller;

    private array $allowedInput = [
        'id',
        'content',
        'sub_title',
    ];

    /**
     * @throws \Exception
     */
    public function handle(Request $request, Service $service): array
    {
        $params = new UpdateParams($this->input($request));

        return success($service->handle($params), __('内容保存成功'));
    }

    private function extendInput(Request $request): array
    {
        return $this->restfulInput($request);
    }
}
